<?php

namespace Pvtl\VoyagerBlog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Pvtl\VoyagerBlog\BlogPost;
use Pvtl\VoyagerBlog\Http\Controllers\Controller;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use Pvtl\VoyagerBlog\Http\Resources\BlogPost as BlogPostResource;

class PostController extends Controller
{
    protected $viewPath = 'voyager-blog';

    /**
     * Route: Gets all posts and passes data to a view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPosts(Request $request)
    {
        // Get featured post
        $featuredPost = BlogPost::where([
                ['status', '=', 'PUBLISHED'],
                ['featured', '=', '1'],
            ])->whereDate('published_date', '<=', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->first();
        $featuredPostId = $featuredPost ? $featuredPost->id : 0;

        // Get all posts
        $posts = BlogPost::where([
                ['status', '=', 'PUBLISHED'],
                ['id', '!=', $featuredPostId],
            ])->whereDate('published_date', '<=', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return $this->makeResponse($request, "{$this->viewPath}::modules/posts/posts", [
            'featuredPost' => $featuredPost,
            'posts' => $posts,
        ], BlogPostResource::collection($posts->load('authorId'))->additional(['meta' => [
            'featuredPost' => ($featuredPost) ? new BlogPostResource($featuredPost): [],
        ]]));
    }

    /**
     * Route: Gets a single posts and passes data to a view
     *
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPost(Request $request, $slug)
    {
        // The post
        $post = BlogPost::where([
                ['slug', '=', $slug],
                ['status', '=', 'PUBLISHED'],
            ])->whereDate('published_date', '<=', Carbon::now())
            ->firstOrFail();
        // Related posts (based on tags)
        $relatedPosts = [];
        if (! empty(trim($post->tags))) {
            $tags = explode(',', $post->tags);
            $relatedPosts = BlogPost::where([
                    ['id', '!=', $post->id],
                ])->where(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags', 'LIKE', '%'.trim($tag).'%');
                    }
                })->limit(4)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return $this->makeResponse($request, "{$this->viewPath}::modules/posts/post", [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ], (new BlogPostResource($post->load('authorId')))->additional(['meta' => [
            'relatedPosts' => ($relatedPosts) ? BlogPostResource::collection($relatedPosts->load('authorId')): [],
        ]]));
    }
}

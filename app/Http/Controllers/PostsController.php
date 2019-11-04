<?php
namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
//after intall interven/image library have to use this
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    //to control the middleware entry in php
    public function __construct()
    {
        $this->middleware('auth');
    }
    //publicfuction to create posts
    //posts.create is directory which is inside the rosources->views
    public function create()
    {
        return view('posts.create');  
    }
    
    //this methood is for show all the post in our home page
    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(2);
        //with('user') this command is optional. user is same user contructor which we get in profilecontroller

        //we can use orderBy('created_at','DESC') instead latest()
        
        //we can use get command intead of paginate command
        //if we use paginate command we have to add this in index.blade.php
        //   <div class="row">
        //     <div class="col-12 d-flex justify-content-center">
        //         {{ $posts->links() }}
        //     </div>
        //  </div>
        //this link command associate with paginatecommand

        return view('posts.index', compact('posts'));
    }
    //method to make a store our posts
    //caption => required means it is a required field 
    //if their are some other fields which is not required just write
    //'another'=>'';
    public function store()
    {
        $data = request()->validate([
            // 'another'=>'',
            'caption' => 'required',
            'image' => 'required | image',
        ]);
        //store my data to storage directory 
        $imagePath = request('image')->store('uploads','public');

        // bring a  library which is called intervention/image 
        // this library basically use for resize all images of the posts 
        // intall it through command line 
        // composer require intervention/image
        //resize the image
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        //Image(is the class in library)
        //make means make me an image
        //public_path is a helper to find the image path
        //storage/$imagePath is the public path
        //fit(width,height) is the method to resize our image


        //create a posts by only authenticate user
        // auth()->user()->posts()->create($data);
        auth()->user()->posts()->create([
            'caption'=> $data['caption'],
            'image'=>$imagePath,
        ]);

        //make a command through the command line 
        //php artisan storage:link
        //it will make the link between app\storage and app\public\storage
        return redirect('/profile/' . auth()->user()->id);
    }

    //make  a public in order to show the post
    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post'));
    }
    //create a folder show.blade.php
}

//in order to turncate/delete a post
//run command through command promote
//php artisan tinker ->
//Post::truncate()



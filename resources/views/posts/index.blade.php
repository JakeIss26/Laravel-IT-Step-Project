<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Posts</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1>All Posts</h1>
                <hr>

                @forelse ($posts as $post)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="card-title">Post Name: {{ $post->name }}</h2>
                            <p class="card-text">User Id: {{ $post->user_id }}</p>
                            <p class="card-text">Publication Time: {{ $post->publication_time }}</p>
                        </div>
                    </div>
                @empty
                    <p>No posts available.</p>
                @endforelse

            </div>
        </div>
    </div>
</body>
</html>
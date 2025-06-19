<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php

   if(isset($_GET['id'])){

    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id='$id'");
    $onePost->execute();

    $posts = $onePost->fetch(PDO::FETCH_OBJ);
   }

    $comments = $conn->query("SELECT * FROM comments WHERE post_id='$id'");
    $comments->execute();

    $comment = $comments->fetchAll(PDO::FETCH_OBJ);
   


?>
 <div class="row">

    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title"><?php echo $posts->title; ?></h5>
            <p class="card-text"><?php echo $posts->body; ?></p>
        </div>
    </div>
</div>

<div class="row">
    <form method="POST" id="comment_data">
   


    <div class="form-floating">
        <input name="username" type="hidden" value="<?php echo $_SESSION['username']; ?>" class="form-control" id="username" >
    
    </div>

    <div class="form-floating">
        <input name="post_id" type="hidden" value="<?php echo $posts->id ;?>" class="form-control" id="post_id" >
    
    </div>

    <div class="form-floating mt-4">
        <textarea rows="9" name="comment" placeholder="body" class="form-control" id="comment"></textarea>
        <label for="floatingPassword">Comment</label>
    </div>

    <button name="submit" id="submit" class="w-100 btn btn-lg btn-primary mt-4" type="submit">Create Comment</button>
    <div id="msg" class="nothing"></div>
    <div id="delete-msg" class="nothing"></div>
    </form>
    
</div>


<div class="row">
    <?php foreach($comment as $singlecomment) : ?>
    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title"><?php echo $singlecomment->username; ?></h5>
            <p class="card-text"><?php echo $singlecomment->comment; ?></p>
            <?php if(isset($_SESSION['username']) AND $_SESSION['username']== $singlecomment->username) : ?>
             <button id="delete-btn" value="<?php echo $singlecomment->id; ?>" class=" btn  btn-danger mt-3" >Delete</button>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>






<?php require "includes/footer.php"; ?>

<script>
    $(document).ready(function(e) {
   

        $(document).on('submit', function(e){
            //alert('form submitted');
            e.preventDefault();
            var formdata = $("#comment_data").serialize()+'&submit=submit';

            $.ajax({
                type: 'post',
                url: 'insert-comments.php',
                data: formdata,

                success: function(){
                   // alert('success');
                   $("#comment").val(null);
                   $("#username").val(null);
                   $("#post_id").val(null);

                   $("#msg").html("Added successfully").toggleClass("alert alert-success bg-success text-white mt-3");
                   fetch();
                }
            })
        });


            $("#delete-btn").on('click', function(e){
            //alert('form submitted');
            e.preventDefault();
            var id = $(this).val();

            $.ajax({
                type: 'post',
                url: 'delete-comment.php',
                data: {
                    delete: 'delete',
                    id: id
                },

                success: function(){
                   // alert(id);


                   $("#delete-msd").html("Deleted successfully").toggleClass("alert alert-success bg-success text-white mt-3");
                   fetch();
                }
            })
        });


        function fetch(){
            setInterval(function() {
                 $("body").load("show.php?id=<?php echo $_GET['id']; ?>")
            }, 4000);
        }

    });
</script>
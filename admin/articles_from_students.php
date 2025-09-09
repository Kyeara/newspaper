<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
}  
?>
<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body { 
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; 
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
      }
      * {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif !important;
      }
      .display-4 { color: #2c3e50; }
      .card { 
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
      }
      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      }
      .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        transition: all 0.3s ease;
      }
      .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
      }
      .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: border-color 0.3s ease;
      }
      .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form action="core/handleForms.php" method="POST">
            <div class="form-group">
              <input type="text" class="form-control mt-4" name="title" placeholder="Input title here">
            </div>
            <div class="form-group">
              <textarea name="description" class="form-control mt-4" placeholder="Submit an article!"></textarea>
            </div>
            <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertArticleBtn">
          </form>

          <div class="display-4">Pending Articles</div>
          <?php $articles = $articleObj->getArticles(); ?>
          <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow articleCard">
            <div class="card-body">
              <h1><?php echo $article['title']; ?></h1> 
              <small><?php echo $article['username'] ?> - <?php echo $article['created_at']; ?> </small>
              <?php if (!empty($article['image_path'])) { ?>
                <div class="mt-2"><img src="<?php echo $article['image_path']; ?>" class="img-fluid rounded" alt="article image"></div>
              <?php } ?>
              <?php if ($article['is_active'] == 0) { ?>
                <p class="text-danger">Status: PENDING</p>
              <?php } ?>
              <?php if ($article['is_active'] == 1) { ?>
                <p class="text-success">Status: ACTIVE</p>
              <?php } ?>
              <p><?php echo $article['content']; ?> </p>
              <div class="mt-2">
                <?php $reqs = $articleObj->getEditRequestsForArticle($article['article_id']); ?>
                <?php foreach ($reqs as $req) { ?>
                  <form action="core/handleForms.php" method="POST" class="d-inline">
                    <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                    <input type="hidden" name="action" value="accept">
                    <button type="submit" name="respondEditRequestBtn" value="1" class="btn btn-sm btn-outline-success">Accept <?php echo $req['username']; ?></button>
                  </form>
                  <form action="core/handleForms.php" method="POST" class="d-inline">
                    <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" name="respondEditRequestBtn" value="1" class="btn btn-sm btn-outline-danger">Reject <?php echo $req['username']; ?></button>
                  </form>
                <?php } ?>
              </div>
              <form class="deleteArticleForm">
                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                <input type="submit" class="btn btn-danger float-right mb-4 deleteArticleBtn" value="Delete">
              </form>
              <form class="updateArticleStatus">
                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                <select name="is_active" class="form-control is_active_select" article_id=<?php echo $article['article_id']; ?>>
                  <option value="">Select an option</option>
                  <option value="0">Pending</option>
                  <option value="1">Active</option>
                </select>
              </form>
              <div class="updateArticleForm d-none">
                <h4>Edit the article</h4>
                <form action="core/handleForms.php" method="POST">
                  <div class="form-group mt-4">
                    <input type="text" class="form-control" name="title" value="<?php echo $article['title']; ?>">
                  </div>
                  <div class="form-group">
                    <textarea name="description" id="" class="form-control"><?php echo $article['content']; ?></textarea>
                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                    <input type="submit" class="btn btn-primary float-right mt-4" name="editArticleBtn">
                  </div>
                </form>
              </div>
            </div>
          </div>  
          <?php } ?> 
        </div>
      </div>
    </div>
    <script>
      // $('.articleCard').on('dblclick', function (event) {
      //   var updateArticleForm = $(this).find('.updateArticleForm');
      //   updateArticleForm.toggleClass('d-none');
      // });

      // $('.deleteArticleForm').on('submit', function (event) {
      //   event.preventDefault();
      //   var formData = {
      //     article_id: $(this).find('.article_id').val(),
      //     deleteArticleBtn: 1
      //   }
      //   if (confirm("Are you sure you want to delete this article?")) {
      //     $.ajax({
      //       type:"POST",
      //       url: "core/handleForms.php",
      //       data:formData,
      //       success: function (data) {
      //         if (data) {
      //           location.reload();
      //         }
      //         else{
      //           alert("Deletion failed");
      //         }
      //       }
      //     })
      //   }
      // })

      $('.is_active_select').on('change', function (event) {
        event.preventDefault();
        var formData = {
          article_id: $(this).attr('article_id'),
          status: $(this).val(),
          updateArticleVisibility:1
        }

        if (formData.article_id != "" && formData.status != "") {
          $.ajax({
            type:"POST",
            url: "core/handleForms.php",
            data:formData,
            success: function (data) {
              if (data) {
                location.reload();
              }
              else{
                alert("Visibility update failed");
              }
            }
          })
        }
      })
    </script>
  </body>
</html>
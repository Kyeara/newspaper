<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
}  
?>
<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="display-4">Shared With Me</div>
          <?php $articles = $articleObj->getSharedForWriter($_SESSION['user_id']); ?>
          <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow">
            <div class="card-body">
              <h2><?php echo $article['title']; ?></h2>
              <small>Owner: <?php echo $article['username'] ?> - <?php echo $article['created_at']; ?> </small>
              <?php if (!empty($article['image_path'])) { ?>
                <div class="mt-2"><img src="<?php echo $article['image_path']; ?>" class="img-fluid rounded" alt="article image"></div>
              <?php } ?>
              <p class="mt-2"><?php echo $article['content']; ?> </p>
            </div>
          </div>  
          <?php } ?> 
        </div>
      </div>
    </div>
  </body>
 </html>


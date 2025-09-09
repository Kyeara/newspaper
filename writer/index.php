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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
      .main-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin: 20px 0;
        padding: 30px;
      }
      .page-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
      }
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
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        border: none;
      }
      .btn-warning {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        border: none;
      }
      .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: border-color 0.3s ease;
      }
      .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
      }
      .article-image {
        border-radius: 8px;
        max-height: 300px;
        object-fit: cover;
        width: 100%;
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="main-container">
            <h1 class="page-title">
              <i class="fas fa-pen-fancy mr-3"></i>Writer Portal
              <small class="text-muted d-block mt-2">Welcome back, <?php echo $_SESSION['username']; ?>!</small>
            </h1>
            
            <div class="card mb-4">
              <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Create New Article</h5>
              </div>
              <div class="card-body">
                <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="title" class="font-weight-bold">Article Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter article title">
                  </div>
                  <div class="form-group">
                    <label for="description" class="font-weight-bold">Content</label>
                    <textarea name="description" class="form-control" id="description" rows="4" placeholder="Write your article content here"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="image" class="font-weight-bold">Featured Image</label>
                    <input type="file" class="form-control-file" name="image" id="image" accept="image/*">
                    <small class="form-text text-muted">Optional: Upload an image to accompany your article</small>
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg" name="insertArticleBtn">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Article
                  </button>
                </form>
              </div>
            </div>
            <h3 class="mb-4"><i class="fas fa-newspaper mr-2"></i>Published Articles</h3>
            <?php $articles = $articleObj->getActiveArticles(); ?>
            <?php foreach ($articles as $article) { ?>
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <h4 class="card-title mb-0"><?php echo $article['title']; ?></h4>
                  <?php if ($article['is_admin'] == 1) { ?>
                    <span class="badge badge-primary">
                      <i class="fas fa-crown mr-1"></i>Admin Post
                    </span>
                  <?php } ?>
                </div>
                
                <div class="article-meta mb-3">
                  <small class="text-muted">
                    <i class="fas fa-user mr-1"></i><strong><?php echo $article['username'] ?></strong>
                    <i class="fas fa-clock ml-3 mr-1"></i><?php echo date('M j, Y g:i A', strtotime($article['created_at'])); ?>
                  </small>
                </div>
                
                <?php if (!empty($article['image_path'])) { ?>
                  <div class="mb-3">
                    <img src="<?php echo $article['image_path']; ?>" class="article-image" alt="Article image" onerror="this.style.display='none'">
                  </div>
                <?php } ?>
                
                <div class="article-content mb-3">
                  <p class="card-text"><?php echo $article['content']; ?></p>
                </div>
                
                <div class="article-actions">
                  <form action="core/handleForms.php" method="POST" class="d-inline">
                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                    <button type="submit" name="requestEditBtn" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit mr-1"></i>Request Edit Access
                    </button>
                  </form>
                </div>
              </div>
            </div>  
            <?php } ?>
          </div>
    </div>
  </body>
</html>
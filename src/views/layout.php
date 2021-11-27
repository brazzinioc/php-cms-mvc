<?php
  declare(strict_types=1);
  
  validateStartSession();
  
  include __DIR__ . '/partials/header.php';
?>
    <div class="">

      <?php
        try {
          echo (isset($content)) ? $content : '';
        } catch (Exception $e) {
          saveLog($e->getMessage(), 'view/layout.php');
        }
      ?>

    </div>

<?php include __DIR__ . '/partials/footer.php'; ?>

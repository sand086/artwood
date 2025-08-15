<?php
    $message = \App\Helpers\MessageHelper::getMessage();
?>

<?php if($message): ?>
    <script src="<?php echo e(asset('js/helpers/messageHelper.js')); ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            showMessage('<?php echo e($message['type']); ?>', '<?php echo e($message['message']); ?>');
        });
    </script>
    <?php
        \Illuminate\Support\Facades\Session::forget('message');
    ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/components/message.blade.php ENDPATH**/ ?>
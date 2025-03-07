<?php

use Framework\Session; ?>

<?php $successMessage = Session::getflashMessage('success_message'); ?>
<?php if ($successMessage !== null) : ?>
    <div class="message success">
        <?= $successMessage ?>
    </div>
<?php endif; ?>

<?php $errorMessage = Session::getflashMessage('error_message'); ?>
<?php if ($errorMessage !== null) : ?>
    <div class="message error">
        <?= $errorMessage ?>
    </div>
<?php endif; ?>

<?php
    $baseUrl = ($isApi) ? url('api/password/reset', $token) : adminUrl('password/reset', $token);
    $link = $baseUrl . '?email=' . urlencode($user->getEmailForPasswordReset());
?>

Click here to reset your password: <a href="{{ $link }}"> {{ $link }} </a>

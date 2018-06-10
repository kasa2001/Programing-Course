<?php
foreach ($data['users'] as $user) {
    echo $this->buildLink($user['nick'], 'user/change/' . $user['id']);
    print "</br>";
}
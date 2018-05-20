<main class="main">
    <h1 class="title">Rejestracja</h1>

    <?= $this->startForm("user/confirm") ?>
    <label for="nick">
        Nazwa użytkownika:
        <input name="nick" type="text">
    </label>
    <label for="email">
        Email:
        <input name="email" type="email">
    </label>
    <label for="password">
        Hasło:
        <input name="password" type="password">
    </label>
    <input type="submit">
    <?= $this->endForm() ?>
</main>
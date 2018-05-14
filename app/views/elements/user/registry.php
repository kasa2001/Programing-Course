<main class="main">
    <h1 class="title">Rejestracja</h1>

    <?= $this->startForm("user/index") ?>
    <label for="name">
        Nazwa użytkownika:
        <input name="name" type="text">
    </label>
    <label for="password">
        Hasło:
        <input name="password" type="password">
    </label>
    <input type="submit">
    <?= $this->endForm() ?>
</main>
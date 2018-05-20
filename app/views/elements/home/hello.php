<main class="main">
    <h1 class="title">Kursy programowania</h1>
    <section>
        <h2>Możliwe specjalizacje</h2>
        <div class="items">
            <?php foreach($data['course'] as $item): ?>
            <p>
                <?= $this->buildLink($item['name'], 'home/course/' . $item['id']) ?>
            </p>
            <?php endforeach ?>
        </div>
    </section>
</main>
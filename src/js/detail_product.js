document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', function() {
        const id = this.id.split('card')[1];
        window.location.href = `product/product_detail.php?id=${id}`;
    });
});
<?php /** @var $this \app\views\View */ ?>
<?php
$id = $this->get('id');
?>
<title>Купить</title>
<style>
    body {
        text-align: center;
    }
</style>
<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
</script>
<script>
    $(document).ready(function () {
        $('#form').submit(function (event) {
            var formData = {
                userID: $('#userID').val(),
                name: $('#name').val(),
                description: $('#description').val(),
                submit: $('#submit').val(),
            };
           $.ajax({
                type: 'POST',
                url: 'b',
                data: formData,
            }).done(function( html ) {
                $( '#view' ).html( html );
            })
            event.preventDefault();
        });
    });
</script>
<div id="view">
    <?php $this->errors->display();?>
    <?php $this->form->display();?>
</div>
</body>
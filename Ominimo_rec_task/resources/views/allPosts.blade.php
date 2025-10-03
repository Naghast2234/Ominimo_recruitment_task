<script setup>

function edit_post(post_id) {
    window.location.href = '/posts/'+post_id+'/edit';
};

function new_post() {
    window.location.href = '/posts/create';
};

async function delete_post(post_id) {
    response = await fetch('/posts/'+post_id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    });

    if (response.status == 200) {
        window.location.reload();
    } else {
        alert('Nie udało się usunąć posta. Kod: '+response.status);
    }
};

function show_post(post_id) {
    window.location.href = '/posts/'+post_id;
};

</script>



<div>
    <div>
    <button onclick="new_post()">Utwórz nowy post</button>
    </div>

    <div class="flex flex-col">


        <?php
        // This is a PHP code. In here i have access to $data, which is an array of all posts.
        // I can print it out with echo technically... Just gotta echo HTML code.

        foreach($data as $post) {
            $title = $post['title'];
            $id = $post['id'];
            $string = "
            <div class=\"flex flex-row\">
                <button onclick=\" show_post($id) \"><h1>$title</h1></button>
                <button class=\" rounded-sm border border-color-amber-500 \" onclick=\" edit_post($id) \">Edytuj</button>
                <button class=\" rounded-sm border border-color-amber-500 \" onclick=\" delete_post($id) \">Usuń</button>
            </div>
            ";
            echo $string;
        }
        ?>
    </div>
    
</div>

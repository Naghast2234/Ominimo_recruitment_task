<script setup>

function edit_post(post_id) {
    window.location.href = '/posts/'+post_id+'/edit';
};

function return_to_posts() {
    window.location.href = '/posts';
};

async function delete_post(post_id) {
    response = await fetch('/posts/'+post_id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    });

    if (response.status == 200) {
        window.location.href = '/posts';
    } else {
        alert('Nie udało się usunąć posta. Kod: '+response.status);
    }
};

async function delete_comment(comment_id) {
    response = await fetch('/comments/'+comment_id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    });
    
    if (response.status == 200) {
        window.location.reload();
    } else {
        alert('Nie udało się usunąć komentarza. Kod: '+response.status);
    }
};

async function add_comment(post_id) {
    content = document.getElementById('comment_content').value;

    response = await fetch('/posts/'+post_id+'/comments',{
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            comment: content
        })
    });

    if (response.status == 200) {
        window.location.reload();
    } else {
        alert('Nie udało się dodać komentarza. Kod: '+response.status);
    }
};

</script>



<div>
    <div class="flex flex-col">
        <button onclick="return_to_posts()">Wróć do wszystkich postów</button>
        <?php
        $post_id = $data['post']->id;
        echo "<button onclick=\"edit_post( $post_id )\">Edytuj posta</button>";
        echo "<button onclick=\"delete_post( $post_id )\">Usuń posta (Wraca do okna wszystkich postów)</button>";
        ?>
    </div>

    <div>
        <p>
            <h1>
                <?php
                    echo $data['post']->title;
                ?>
            </h1>
            <?php
                echo $data['post']->content;
            ?>
        </p>
    </div>

    <div class="flex flex-row">
        <?php
        $post_id = $data['post']->id;
        echo "<button onclick=\"add_comment( $post_id )\">Dodaj komentarz</button>";
        ?>
    <div>
        <textarea id="comment_content"></textarea>    
    </div>
    </div>

    <div>
        <h1>Komentarze:</h1>
        <div class="flex flex-col">
            <?php
            $comments = $data['comments'];

            foreach ($comments as $comment) {
                $comment_id = $comment->id;
                $comment_content = $comment->comment;
                $string = "
                <div class=\"flex flex-row\">
                    <button onclick=\"delete_comment( $comment_id )\" >Usuń komentarz</button>
                    <p>$comment_content</p>
                </div>
                ";
                echo $string;
            }
            ?>
        </div>
    </div>
    
</div>

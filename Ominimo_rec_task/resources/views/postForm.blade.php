<script setup>
// This will be multipurpose. I will define functions to update AND add a post, but will decide which one to use
// Depending on whether a post prop is defined and passed (through a php tag)
// I have altered the adding and updating post functions in a controller to return the ID of a post, so, i can navigate to showing it after it's created.

async function create_post() {
    var form_content = document.getElementById('post_content').value;
    var form_title = document.getElementById('post_title').value;

    console.log(form_content);
    console.log(form_title);

    response = await fetch('/posts', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            content: form_content,
            title: form_title
        })
    });

    console.log(response);

    if (response.status == 200) {
        post_id = response.headers.get('data');
        window.location.href = '/posts/'+post_id;
    } else {
        alert('Nie udało się utworzyć posta. Kod: '+response.status);
    }
}

async function update_post(post_id) {
    form_content = document.getElementById('post_content').value;
    form_title = document.getElementById('post_title').value;

    response = await fetch('/posts/'+post_id, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            content: form_content,
            title: form_title
        })
    });

    if (response.status == 200) {
        window.location.href = '/posts/'+post_id;
    } else {
        alert('Nie udało się zaktualizować posta. Kod: '+response.status);
    }
}


</script>

<div>
    <div class="flex flex-row">
        <div>
            <h1>Tytuł posta</h1>
            <?php
            if (!isset($data)) {
                echo "<input type=\"text\" id=\"post_title\"></input>";
            } else {
                $title = $data->title;
                echo "<input type=\"text\" id=\"post_title\" value=\"$title\"></input>";
            }
            ?>
        </div>
        <div>
            <h1>Zawartość posta</h1>
            <?php
            if (!isset($data)) {
                echo "<textarea id=\"post_content\"></textarea>";
            } else {
                $content = $data->content;
                echo "<textarea id=\"post_content\">$content</textarea>";
            }
            ?>
        </div>
        <?php
        if (!isset($data)) {
            echo "<button onclick=\"create_post()\">Dodaj posta</button>";
        } else {
            $post_id = $data->id;
            echo "<button onclick=\"update_post($post_id)\">Aktualizuj posta</button>";
        }
        ?>
        
    </div>
</div>

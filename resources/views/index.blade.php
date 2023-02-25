<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Generate unique passwords</title>

        <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
    </head>
    <body>
        <main class="container">
            <h1>Generate unique passwords for any site!</h1>
            <form id="form-password" action="/password" method="post">
                @csrf
                <button type="submit" id="gen-password">Generate Now</button>
                <div></div>
            </form>
        </main>

        <script>
            const $btn = document.querySelector('#gen-password');

            $btn.addEventListener('click', function (e) {
                e.preventDefault();

                fetch('/password', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: JSON.stringify({
                        _token: document.querySelector('#form-password [name="_token"]').value,
                    })
                }).then((response) => {
                    if (!response.ok) {
                        throw new Error('Not a valid response.');
                    }

                    return response.text();
                }).then((response) => {
                    unsecuredCopyToClipboard(response);
                    document.querySelector('#form-password > div').innerHTML = 'Copied to clipboard!';
                }).catch((error) => {
                    document.querySelector('#form-password > div').innerHTML = 'Something went wrong. Please try again later!';
                });

                function unsecuredCopyToClipboard(text) {
                    const textArea = document.createElement("textarea");
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                    } catch (err) {
                        console.error('Unable to copy to clipboard', err);
                    }
                    document.body.removeChild(textArea);
                }
            });
        </script>
    </body>
</html>

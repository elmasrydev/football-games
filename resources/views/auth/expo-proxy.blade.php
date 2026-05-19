<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticating...</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #1b1b18; color: #fff; }
        .message { text-align: center; }
    </style>
    <script>
        window.onload = function() {
            // Google OAuth returns the tokens in the URL fragment (e.g., #state=exp://...&access_token=...)
            const hash = window.location.hash.substring(1);
            const params = new URLSearchParams(hash);
            
            // We encoded the Expo Go deep link into the state parameter!
            const returnUrl = params.get('state');
            
            if (returnUrl && returnUrl.startsWith('exp://')) {
                // Dynamically redirect back to the exact Expo Go IP that initiated the request
                window.location.href = returnUrl + "/--/expo-auth-session#" + hash;
            } else {
                document.getElementById('status').innerText = "Authentication failed: Could not determine return URL.";
            }
        };
    </script>
</head>
<body>
    <div class="message">
        <h2 id="status">Redirecting back to the app...</h2>
        <p>Please wait.</p>
    </div>
</body>
</html>

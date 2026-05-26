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
            // Google OAuth returns the tokens/codes in the query string or URL fragment
            const hashString = window.location.hash.substring(1);
            const queryString = window.location.search.substring(1);
            
            const hashParams = new URLSearchParams(hashString);
            const queryParams = new URLSearchParams(queryString);
            
            // We encoded the Expo Go deep link into the state parameter!
            const returnUrl = hashParams.get('state') || queryParams.get('state');
            
            if (returnUrl && returnUrl.startsWith('exp://')) {
                // Reconstruct the full parameters to pass back to Expo AuthSession
                const fullParams = window.location.search + window.location.hash;
                // Dynamically redirect back to the exact Expo Go IP that initiated the request
                window.location.href = returnUrl + "/--/expo-auth-session" + fullParams;
            } else {
                document.getElementById('status').innerHTML = "Authentication failed: Could not determine return URL.<br><br>State was: " + returnUrl + "<br>Query: " + window.location.search;
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

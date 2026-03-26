<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require dirname(__DIR__) . '/templates/opengraph-meta.php'; ?>
    <title>Bartolomeus Bima | Official Portfolio</title>
    <link rel="stylesheet" href="/assets/css/fonts.css">    <style>
        :root {
            color-scheme: dark;
            --bg: #080808;
            --fg: #f5f5f5;
            --muted: rgba(245, 245, 245, 0.72);
            --panel: rgba(255, 255, 255, 0.06);
            --line: rgba(255, 255, 255, 0.12);
            --green: #00ff47;
            --red: #ff2b2b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            overflow: hidden;
            background:
                radial-gradient(circle at top, rgba(255, 255, 255, 0.04), transparent 36%),
                var(--bg);
            color: var(--fg);
            font-family: "Manrope", sans-serif;
        }

        .not-found-shell {
            width: min(100%, 960px);
            padding: 40px 24px;
            display: grid;
            place-items: center;
            text-align: center;
        }

        .not-found-code {
            margin: 0;
            font-size: clamp(7rem, 24vw, 15rem);
            line-height: 0.88;
            font-weight: 800;
            letter-spacing: -0.08em;
            color: #020202;
            text-shadow:
                -4px -4px 0 var(--green),
                4px 4px 0 var(--red);
        }

        .not-found-copy {
            margin: 18px 0 28px;
            max-width: 420px;
            font-size: 0.98rem;
            line-height: 1.7;
            color: var(--muted);
        }

        .not-found-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 188px;
            min-height: 58px;
            padding: 0 28px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--panel);
            color: var(--fg);
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: transform 160ms ease, border-color 160ms ease, background 160ms ease;
        }

        .not-found-home:hover,
        .not-found-home:focus-visible {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.1);
            outline: none;
        }
    </style>
</head>
<body>
    <main class="not-found-shell">
        <h1 class="not-found-code">404</h1>
        <p class="not-found-copy">The page you were looking for does not exist or has already moved somewhere else.</p>
        <a class="not-found-home" href="/">Back to Home</a>
    </main>
</body>
</html>





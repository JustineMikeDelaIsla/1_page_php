<?php

$previousPage = !empty($_SERVER['HTTP_REFERER'])
    ? $_SERVER['HTTP_REFERER']
    : 'No previous webpage detected.';

$protocol = "http";

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $protocol = "https";
}

$currentPage = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Observe</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --background: #f7f7f5;
            --text: #202020;
            --secondary: #777;
            --border: #e3e3e0;
            --input: #ffffff;
            --user: #eeeeeb;
            --button: #202020;
            --button-text: #ffffff;
        }

        body {
            min-height: 100vh;
            background: var(--background);
            color: var(--text);
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        .intro {
            position: fixed;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .intro.hide {
            opacity: 0;
            transform: translateY(-20px);
            pointer-events: none;
        }

        .intro-content {
            width: 100%;
            max-width: 620px;
            text-align: center;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input {
            width: 100%;
            height: 58px;
            padding: 0 58px 0 20px;
            border-radius: 18px;
            border: 1px solid var(--border);
            outline: none;
            background: var(--input);
            color: var(--text);
            font-size: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.035);
        }

        .input:focus {
            border-color: #bdbdb8;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        }

        .input::placeholder {
            color: #aaa;
        }

        .send {
            position: absolute;
            right: 9px;
            top: 9px;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 13px;
            background: var(--button);
            color: var(--button-text);
            cursor: pointer;
            font-size: 17px;
        }

        .send:hover {
            background: #333;
        }

        .hint {
            margin-top: 15px;
            color: #aaa;
            font-size: 11px;
        }

        .conversation {
            display: none;
            width: 100%;
            max-width: 720px;
            margin: auto;
            padding: 80px 25px 120px;
        }

        .user {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 65px;
            opacity: 0;
            transform: translateY(12px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .user.show {
            opacity: 1;
            transform: translateY(0);
        }

        .user span {
            max-width: 75%;
            padding: 11px 16px;
            background: var(--user);
            border-radius: 15px 15px 4px 15px;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
            word-break: break-word;
        }

        .response {
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .response.show {
            opacity: 1;
            transform: translateY(0);
        }

        .response p {
            color: #333;
            font-size: 17px;
            line-height: 1.8;
        }

        .label {
            color: #aaa;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 7px;
        }

        .thinking {
            display: flex;
            align-items: center;
            gap: 5px;
            height: 30px;
            margin-bottom: 25px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .thinking.show {
            opacity: 1;
        }

        .dot {
            width: 4px;
            height: 4px;
            background: #999;
            border-radius: 50%;
            animation: pulse 1.2s infinite;
        }

        .dot:nth-child(2) {
            animation-delay: 0.15s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.3s;
        }

        @keyframes pulse {

            0%, 100% {
                opacity: 0.25;
                transform: translateY(0);
            }

            50% {
                opacity: 1;
                transform: translateY(-2px);
            }

        }

        .finish {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            opacity: 0;
            transition: opacity 0.7s;
        }

        .finish.show {
            opacity: 1;
        }

        .finish button {
            background: none;
            border: none;
            color: #999;
            font-size: 13px;
            cursor: pointer;
            padding: 5px 0;
        }

        .finish button:hover {
            color: #555;
        }

        /* Footer */

        .footer {
            text-align: center;
            padding: 25px 15px;
            color: #999;
            font-size: 12px;
            border-top: 1px solid var(--border);
            margin-top: 40px;
        }

        .footer p {
            margin: 0;
        }

        @media (max-width: 600px) {

            .conversation {
                padding: 45px 18px 100px;
            }

            .response p {
                font-size: 19px;
                line-height: 1.7;
            }

            .user span {
                max-width: 88%;
            }

        }

    </style>

</head>

<body>

    <section class="intro" id="intro">

        <div class="intro-content">

            <div class="input-wrapper">

                <input
                    class="input"
                    id="userInput"
                    type="text"
                    placeholder="Say something..."
                    autocomplete="off"
                >

                <button
                    class="send"
                    onclick="start()"
                >
                    ↑
                </button>

            </div>

            <div class="hint">
                Press Enter to continue
            </div>

        </div>

    </section>


    <main class="conversation" id="conversation">
        <p><?
        <div id="messages"></div>

    </main>


    <footer class="footer">

        <p>
            &copy; <?php echo date("Y"); ?> PLMUN BSIT-3K &middot; Group 5
        </p>

    </footer>


    <script>

        const previousPage =
            <?php echo json_encode($previousPage); ?>;

        const currentPage =
            <?php echo json_encode($currentPage); ?>;


        async function start() {

            const input = document.getElementById("userInput");
            const value = input.value.trim();

            if (!value) {
                input.focus();
                return;
            }

            input.disabled = true;

            document
                .getElementById("intro")
                .classList.add("hide");

            await sleep(700);

            document
                .getElementById("intro")
                .style.display = "none";

            const conversation =
                document.getElementById("conversation");

            conversation.style.display = "block";

            await addUser(value);

            await sleep(700);

            await speak(
                "Before I answer, let me take a quick look around..."
            );

            await speak(
                "I'll start with your internet connection."
            );


            if (navigator.onLine) {

                await speak(
                    "You're currently connected to the internet."
                );

            } else {

                await speak(
                    "It looks like you're currently offline."
                );

            }


            await speak(
                "Now I'll check your public IP address."
            );

            const ip = await getIP();


            if (ip) {

                await speak(
                    `Your public IP address is ${ip}.`
                );

            } else {

                await speak(
                    "I couldn't retrieve your public IP address."
                );

            }


            await speak(
                `You're using ${getOS()}.`
            );


            await speak(
                `You're browsing with ${getBrowser()}.`
            );


            await speak(
                `Your screen resolution is ${screen.width} × ${screen.height}.`
            );


            await speak(
                `Your browser language is ${navigator.language || "unknown"}.`
            );


            const timezone =
                Intl.DateTimeFormat()
                .resolvedOptions()
                .timeZone || "unknown";


            await speak(
                `Your timezone is ${timezone}.`
            );


            if (
                previousPage &&
                !previousPage.includes("No previous webpage")
            ) {

                await speak(
                    `Before arriving here, your browser came from ${previousPage}.`
                );

            } else {

                await speak(
                    "I couldn't see a previous webpage before this one."
                );

            }


            await speak(
                `Right now, you're viewing ${currentPage}.`
            );


            await speak(
                `Your detected connection type is ${getConnectionType()}.`
            );


            const finish =
                document.createElement("div");

            finish.className = "finish";

            finish.innerHTML = `
                <button onclick="location.reload()">
                    Start over
                </button>
            `;

            document
                .getElementById("messages")
                .appendChild(finish);


            setTimeout(function() {
                finish.classList.add("show");
            }, 200);

        }


        async function addUser(text) {

            const messages =
                document.getElementById("messages");

            const user =
                document.createElement("div");

            user.className = "user";

            user.innerHTML = `
                <span>
                    ${escapeHTML(text)}
                </span>
            `;

            messages.appendChild(user);

            await sleep(80);

            user.classList.add("show");

        }


        async function speak(text) {

            const messages =
                document.getElementById("messages");


            const thinking =
                document.createElement("div");

            thinking.className = "thinking";

            thinking.innerHTML = `
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            `;

            messages.appendChild(thinking);

            await sleep(80);

            thinking.classList.add("show");

            await sleep(700);

            thinking.classList.remove("show");

            await sleep(250);

            thinking.remove();


            const response =
                document.createElement("div");

            response.className = "response";

            response.innerHTML = `
                <div class="label">
                    observe
                </div>

                <p>
                    ${escapeHTML(text)}
                </p>
            `;

            messages.appendChild(response);

            await sleep(80);

            response.classList.add("show");


            await sleep(
                Math.max(
                    900,
                    text.length * 16
                )
            );

        }


        async function getIP() {

            try {

                const response =
                    await fetch(
                        "https://api.ipify.org?format=json"
                    );


                if (!response.ok) {
                    throw new Error();
                }


                const data =
                    await response.json();

                return data.ip;

            } catch {

                return null;

            }

        }


        function getOS() {

            const ua =
                navigator.userAgent;


            if (/Windows/i.test(ua))
                return "Windows";


            if (/Android/i.test(ua))
                return "Android";


            if (/iPhone|iPad|iPod/i.test(ua))
                return "iOS";


            if (/Mac/i.test(ua))
                return "macOS";


            if (/Linux/i.test(ua))
                return "Linux";


            return "an unknown operating system";

        }


        async function getBrowser() {

    const ua = navigator.userAgent;

    // Brave
    if (navigator.brave && await navigator.brave.isBrave()) {
        return "Brave";
    }

    // Samsung Internet
    if (/SamsungBrowser/i.test(ua)) {
        return "Samsung Internet";
    }

    // Opera
    if (/OPR|Opera Mini|Opera Mobi/i.test(ua)) {
        return "Opera";
    }

    // Microsoft Edge
    if (/EdgA|EdgiOS|Edg/i.test(ua)) {
        return "Microsoft Edge";
    }

    // Vivaldi
    if (/Vivaldi/i.test(ua)) {
        return "Vivaldi";
    }

    // Arc
    if (/Arc/i.test(ua)) {
        return "Arc";
    }

    // Yandex Browser
    if (/YaBrowser/i.test(ua)) {
        return "Yandex Browser";
    }

    // UC Browser
    if (/UCBrowser|UC Browser/i.test(ua)) {
        return "UC Browser";
    }

    // QQ Browser
    if (/QQBrowser/i.test(ua)) {
        return "QQ Browser";
    }

    // Huawei Browser
    if (/HuaweiBrowser/i.test(ua)) {
        return "Huawei Browser";
    }

    // DuckDuckGo Browser
    if (/DuckDuckGo/i.test(ua)) {
        return "DuckDuckGo";
    }

    // Tor Browser
    if (/TorBrowser/i.test(ua)) {
        return "Tor Browser";
    }

    // Firefox
    if (/FxiOS|Firefox/i.test(ua)) {
        return "Mozilla Firefox";
    }

    // Google Chrome
    if (
        /CriOS|Chrome/i.test(ua) &&
        !/Edg|OPR|SamsungBrowser|Vivaldi|YaBrowser|UCBrowser/i.test(ua)
    ) {
        return "Google Chrome";
    }

    // Safari
    if (
        /Safari/i.test(ua) &&
        !/Chrome|CriOS|Edg|OPR|Android|SamsungBrowser/i.test(ua)
    ) {
        return "Safari";
    }

    // Internet Explorer
    if (/MSIE|Trident/i.test(ua)) {
        return "Internet Explorer";
    }

    return "Unknown browser";
}


        function getConnectionType() {

            if (navigator.connection) {

                return (
                    navigator.connection.effectiveType ||
                    "unknown"
                ).toUpperCase();

            }

            return "unknown";

        }


        function escapeHTML(text) {

            const div =
                document.createElement("div");

            div.textContent = text;

            return div.innerHTML;

        }


        function sleep(ms) {

            return new Promise(function(resolve) {

                setTimeout(resolve, ms);

            });

        }


        document
            .getElementById("userInput")
            .addEventListener(
                "keydown",
                function(event) {

                    if (event.key === "Enter") {
                        start();
                    }

                }
            );

    </script>

</body>

</html>
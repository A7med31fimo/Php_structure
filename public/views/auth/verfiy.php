<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="../../assets/css/verify.css">
</head>

<body>

    <form id="verifyForm">
        <p>We send a verification code to your email
        <h2><?= $_GET['email'] ?> </h2></p>
            <h3>Enter verification code</h3>
            <input type="text" id="code" placeholder="6-digit code" required>
            <button type="submit">Verify</button>
            <div id="alertBox"></div>
    </form>

    <script>
        const form = document.getElementById("verifyForm");
        const alertBox = document.getElementById("alertBox");
        const email = new URLSearchParams(window.location.search).get("email");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const code = document.getElementById("code").value;

            const res = await fetch("http://localhost/Php_structure/verify", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    email,
                    code
                }),
            });

            const result = await res.json();
            if (res.ok) {
                alertBox.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                setTimeout(() => window.location.href = "login.php", 1500);
            } else {
                alertBox.innerHTML = `<div class="alert alert-danger">${result.error}</div>`;
            }
        });
    </script>
</body>

</html>
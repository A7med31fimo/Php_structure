function initAuthForm(type) {
  const form = document.getElementById(
    type === "login" ? "loginForm" : "registerForm"
  );
  const alertBox = document.getElementById("alertBox");
  const baseURL = "http://localhost/Php_structure";

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    alertBox.innerHTML = "";

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    var res;
    try {
      const url = `${baseURL}/${type}`;
      res = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json; charset=UTF-8",
          Accept: "application/json; charset=UTF-8",
        },
        body: JSON.stringify(data),
      });
      // console.log(res.json);

      if (
        res.ok &&
        (res.status === "success" || res.status === 200)
      ) {
        // ✅ لو المستخدم سجل (register)
        if (type === "register") {
          alertBox.innerHTML = `<div class="alert alert-success">${
            res.message || "Registration successful!"
          }</div>`;
          
          setTimeout(() => {
          window.location.href = `http://localhost/Php_structure/public/views/auth/verfiy.php?email=${encodeURIComponent(
            data.email
          )}`;
        }, 1000);
          return; // 🔴 نوقف الكود هنا، ما نكملش باقي الخطوات
        }
        const text = await res.text();
        // console.log("🧾 Raw Response:", text);
        
        let result;
        try {
          result = JSON.parse(text);
        } catch (err) {
          console.error("⚠️ JSON parse error:", err);
          alertBox.innerHTML = `<div class="alert alert-danger">Invalid server response</div>`;
          return;
        }
        
        localStorage.setItem("auth_token", result.token.access_token);
        localStorage.setItem("user_email", result.user.email);
        localStorage.setItem("user_name", result.user.name);

        alertBox.innerHTML = `<div class="alert alert-success">${
          result.message || "Login successful!"
        }</div>`;
         setTimeout(() => {
           window.location.href = `http://localhost/Php_structure/public/views/home.php`;
         }, 1000);
      } else {
        alertBox.innerHTML = `<div class="alert alert-danger">${
          result.error || "Invalid credentials"
        }</div>`;
      }
    } catch (err) {
      res = await res.text();
      res = JSON.parse(res);
      alertBox.innerHTML = `<div class="alert alert-danger">${res.error}</div>`;
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const logoutBtn = document.getElementById("logoutBtn");
  const token = localStorage.getItem("auth_token");
  if (!logoutBtn) return;

  logoutBtn.addEventListener("click", async (e) => {
    e.preventDefault();
     localStorage.clear();
    try {
      const res = await fetch("http://localhost/Php_structure/logout", {
        method: "POST",
        credentials: "include", // ✅ ensures cookies (session id) are sent
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
      });
      
      if (res.ok) {
        // optional: await res.json();
        alert("You have been logged out successfully.");
        window.location.href =
          "http://localhost/Php_structure/public/views/auth/login.php";
      } else {
        alert("Logout failed. Please try again.");
      }
    } catch (err) {
      console.error("Logout error:", err);
      alert("Server error, please try again.");
    }
  });
});

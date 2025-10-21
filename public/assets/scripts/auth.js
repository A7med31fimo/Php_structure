function initAuthForm(type) {
  const form = document.getElementById(type === 'login' ? 'loginForm' : 'registerForm');
  const alertBox = document.getElementById('alertBox');
  const baseURL = "http://localhost/Php_structure"; // غيّرها لـ /public لو index هناك

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    alertBox.innerHTML = '';

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    // console.log("📤 Sending data:", data);

    try {
      const url = `${baseURL}/${type}`;
      // console.log(`🌍 Sending POST to: ${url}`);

      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });

      // console.log("📦 Response status:", res.status);

      const text = await res.text(); // ناخد النص الخام عشان لو السيرفر مش راجع JSON
      // console.log("📩 Raw response:", text);

      let result;
      try {
        result = JSON.parse(text);
      } catch {
        result = { error: "Response is not valid JSON" };
      }

      if (res.ok) {
        alertBox.innerHTML = `<div class="alert alert-success">${result.message || 'Success!'}</div>`;
        setTimeout(() => window.location.href = '../../views/home.php', 1000);  
      } else {
        alertBox.innerHTML = `<div class="alert alert-danger">${result.error || 'Invalid credentials'}</div>`;
      }

    } catch (err) {
      console.error("❌ Network or server error:", err);
      alertBox.innerHTML = `<div class="alert alert-danger">Server error, please try again</div>`;
    }
  });
}

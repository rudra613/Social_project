document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("login-form");
  const logoutBtn = document.getElementById("logout-btn");
  const loginArea = document.getElementById("jwt-login");
  const postsArea = document.getElementById("posts-area");
  const postsContainer = document.getElementById("posts-container");

  // Handle login
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();

      if (!username || !password) {
        alert("Please enter both username and password.");
        return;
      }

      fetch(jwtData.token_url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
      })
        .then(res => res.json())
        .then(data => {
          if (data.token) {
            localStorage.setItem("jwt_token", data.token);
            alert("Login successful!");
            loadProtectedPosts();
          } else {
            alert("Login failed: " + (data.message || "Unknown error"));
          }
        })
        .catch(error => {
          console.error("Login error:", error);
          alert("Network error during login.");
        });
    });
  }

  // Handle logout
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function () {
      localStorage.removeItem("jwt_token");
      alert("Logged out successfully.");
      location.reload();
    });
  }

  // Fetch protected posts
  function loadProtectedPosts() {
    const token = localStorage.getItem("jwt_token");

    if (!token) {
      showLogin();
      return;
    }

    fetch(jwtData.posts_url, {
      method: "GET",
      headers: {
        "Authorization": "Bearer " + token
      }
    })
      .then(res => {
        if (!res.ok) throw new Error("Unauthorized or Token Expired");
        return res.json();
      })
      .then(posts => {
        showPosts();
        postsContainer.innerHTML = "";

        posts.forEach(post => {
          postsContainer.innerHTML += `
            <div class="post">
              <h3>${post.title.rendered}</h3>
              <p>${post.excerpt.rendered}</p>
            </div>
          `;
        });
      })
      .catch(error => {
        console.error("Fetch error:", error);
        alert("Access denied. Please login again.");
        localStorage.removeItem("jwt_token");
        showLogin();
      });
  }

  // Show login form
  function showLogin() {
    if (loginArea) loginArea.style.display = "block";
    if (postsArea) postsArea.style.display = "none";
  }

  // Show posts section
  function showPosts() {
    if (loginArea) loginArea.style.display = "none";
    if (postsArea) postsArea.style.display = "block";
  }

  // Initial check
  if (localStorage.getItem("jwt_token")) {
    loadProtectedPosts();
  } else {
    showLogin();
  }
});

<?php
session_start();
$name  = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : "Guest";
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : "guest@example.com";
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : "default.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mini Social Network</title>
  <link rel="stylesheet" href="style.css">  
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
    }

    .container {
      display: flex;
      align-items: flex-start;
      gap: 20px;
      padding: 20px;
    }

    .profile {
      width: 200px;
      min-height: 250px;
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .add-post {
      flex: 1;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    textarea {
      width: 100%;
      height: 70px;
      border-radius: 5px;
      border: 1px solid #ccc;
      padding: 10px;
    }

    .btn, .add-post button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .post { 
     position: relative; 
  border: 1px solid #ccc; 
  padding: 10px; 
  margin: 10px 0; 
  border-radius: 8px;
  background: #fafafa;
  margin-top: 20px;
    }

    .post img {
      max-width: 100%;
      margin-top: 10px;
      border-radius: 8px;
    }

    .actions button {
      background: none;
      border: none;
      cursor: pointer;
      margin-right: 10px;
      color: #007BFF;
    }

    .delete-btn {
     position: absolute;
  top: 8px;
  right: 8px;
  background: none;
  border: none;
  cursor: pointer;
    }
    .delete-btn img {
       width: 10px;
  height: 1ox;
      
    }
    .button-row {
  display: flex;
  justify-content: space-between; 
  align-items: center;
  margin-top: 10px;
}

.img-btn {
  display: flex;
  align-items: center;
  gap: 8px; 
  background-color: #fcf7f7ff;
  color: #333;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
}

.img-btn img {
  vertical-align: middle;
}

.post-btn {
  padding: 10px 20px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.profile-pic-container {
    width: 100px;   
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 10px auto; 
    border: 2px solid #007BFF; 
    position: relative;
}

.profile-pic-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.edit-btn {
    position: absolute; 
    bottom: 0;
    right: 0;
    background: #007BFF;
    color: white;
    border: none;
    border-radius: 50%;
    padding: 3px 5px;
    cursor: pointer;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}


    </style>
</head>
<body>
  <div class="container">
    
    <div class="profile">
      <div class="profile-pic-container">
    <img src="uploads/<?php echo $profile_pic; ?>" alt="Profile Pic" class="profile-pic" id="profilePreview">
    <form id="updatePicForm" enctype="multipart/form-data">
        <input type="file" id="newProfilePic" name="newProfilePic" accept="image/*" style="display:none;">
    </form>
    <button class="edit-btn" onclick="document.getElementById('newProfilePic').click()">✎</button>
</div>

    <h3><?php echo $name; ?></h3>
    <p><?php echo $email; ?></p>
</div>


    
    <div style="flex:1;">
      <div class="add-post">
        <textarea id="postContent" placeholder="What's on your mind?"></textarea><br><br>
       <div class="button-row">
  
  <input type="file" id="postImage" accept="image/*" style="display:none" onchange="handleImageUpload(event)">

  
  <button class="img-btn" onclick="document.getElementById('postImage').click()">
    <img src="image.png" alt="Add Image" width="20" height="20"> Add Image
  </button>

  <button class="post-btn" onclick="addPost()">Post</button>
</div>


      </div>

      <div id="posts"></div>
    </div>
  </div>

  <script>
    let posts = [
      { id: 1, text: "Innovation, teamwork, and growth—it’s what we stand for!", image: null, likes: 2, dislikes: 1 },
      { id: 2, text: "Building a better tomorrow, together!", image: null, likes: 10, dislikes: 0 }
    ];

    function renderPosts() {
      const postsContainer = document.getElementById("posts");
      postsContainer.innerHTML = "";
      posts.forEach(post => {
        const postDiv = document.createElement("div");
        postDiv.classList.add("post");

        let imageHTML = post.image ? `<img src="${post.image}" alt="Post Image">` : "";

       postDiv.innerHTML = `
  <button class="delete-btn" onclick="deletePost(${post.id})">
    <img src="close.png" alt="Delete">
  </button>
  <p>${post.text}</p>
  ${imageHTML}
  <div class="actions">
    <button onclick="likePost(${post.id})">👍 Like ${post.likes}</button>
    <button onclick="dislikePost(${post.id})">👎 Dislike ${post.dislikes}</button>
  </div>
`;

        postsContainer.appendChild(postDiv);
      });
    }

    function addPost() {
      const content = document.getElementById("postContent").value;
      const fileInput = document.getElementById("postImage");
      const file = fileInput.files[0];

      if (content.trim() === "" && !file) return;

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const newPost = { id: Date.now(), text: content, image: e.target.result, likes: 0, dislikes: 0 };
          posts.unshift(newPost);
          renderPosts();
          document.getElementById("postContent").value = "";
          fileInput.value = "";
        };
        reader.readAsDataURL(file);
      } else {
        const newPost = { id: Date.now(), text: content, image: null, likes: 0, dislikes: 0 };
        posts.unshift(newPost);
        renderPosts();
        document.getElementById("postContent").value = "";
      }
    }

    function likePost(id) {
      const post = posts.find(p => p.id === id);
      if (post) {
        post.likes++;
        renderPosts();
      }
    }

    function dislikePost(id) {
      const post = posts.find(p => p.id === id);
      if (post) {
        post.dislikes++;
        renderPosts();
      }
    }

    function deletePost(id) {
      posts = posts.filter(p => p.id !== id);  
      renderPosts();
    }
    function handleImageUpload(event) {
  const file = event.target.files[0];
  if (!file) return;

  const content = document.getElementById("postContent").value;
  const reader = new FileReader();

  reader.onload = function(e) {
    const newPost = { 
      id: Date.now(), 
      text: content || "📷 Shared an image", 
      image: e.target.result,   
      likes: 0, 
      dislikes: 0 
    };
    posts.unshift(newPost);
    renderPosts();
    document.getElementById("postContent").value = "";
    event.target.value = ""; 
  };

  reader.readAsDataURL(file);
}
  renderPosts();
  </script>
</body>
</html>

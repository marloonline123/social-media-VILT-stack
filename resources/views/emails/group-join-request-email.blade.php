<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lafriendly | New Join Request</title>
<style>
  body {
    background: linear-gradient(to bottom right, #3b82f6, #1e40af);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  main {
    background: white;
    max-width: 32rem;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    text-align: center;
  }
  .logo {
    width: 200px;
  }
  .group-avatar {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #3b82f6;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 16px auto;
  }
  .group-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .title {
    font-size: 1.875rem;
    font-weight: bold;
    color: #1f2937;
    margin-top: 16px;
  }
  .highlight {
    color: #3b82f6;
  }
  .description {
    color: #4b5563;
    margin-top: 8px;
  }
  .request-message {
    background: #dbeafe;
    padding: 16px;
    border-radius: 8px;
    margin-top: 16px;
    color: #1e40af;
    border-left: 4px solid #3b82f6;
  }
  .group-details {
    margin-top: 16px;
    color: #374151;
    text-align: left;
  }
  .group-details h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #3b82f6;
  }
  .group-details ul {
    list-style: none;
    margin-top: 8px;
  }
  .group-details li {
    margin-bottom: 4px;
  }
  .cta-button, .decline-button {
    display: inline-block;
    background: #3b82f6;
    color: white;
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 8px;
    margin: 12px 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.3s;
    border: none;
    cursor: pointer;
    text-decoration: none;
  }
  .cta-button:hover {
    background: #2563eb;
  }
  .decline-button {
    background: #ef4444;
  }
  .decline-button:hover {
    background: #dc2626;
  }
  .footer {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 16px;
  }
  .footer a {
    color: #3b82f6;
    text-decoration: none;
  }
  .footer a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>
<main>
  <!-- App Logo -->
  <div>
    <img class="logo" src="https://www.logoai.com/oss/icons/2021/12/02/EoLJeYhT6YPfd26.png" alt="Lafriendly App Logo">
  </div>

  <!-- Email Title -->
  <h2 class="title">New Join Request for <span class="highlight">{{ $group->name }}</span> 📥</h2>
  
  <p class="description">Hey <strong>{{ $admin->name }}</strong>, you have a new join request!</p>
  
  <!-- Group Avatar -->
  <div class="group-avatar">
    <img src="{{ $group->avatar }}" alt="Group Avatar">
  </div>

  <!-- Request Message -->
  <div class="request-message">
    <p><strong>{{ $user->name }}</strong> has requested to join <strong>{{ $group->name }}</strong>. Review their request and decide whether to approve or decline. ⚡</p>
  </div>

  <!-- Group Highlights -->
  <div class="group-details">
    <h3>Group Details:</h3>
    <ul>
      <li>📌 <strong>Group Name:</strong> {{ $group->name }}</li>
      <li>📆 <strong>Created On:</strong> {{ $group->created_at->format('M d, Y') }}</li>
      <li>👥 <strong>User:</strong> {{ $user->name }}</li>
    </ul>
  </div>

  <!-- Action Buttons -->
  <div class="cta-buttons">
    <a href="{{ route('groups.approve', ['group' => $group->id, 'user' => $user->id]) }}" class="cta-button">Approve Request</a>
    <a href="{{ route('groups.decline', ['group' => $group->id, 'user' => $user->id]) }}" class="decline-button">Decline Request</a>
  </div>

  <!-- Footer -->
  <p class="footer">Need assistance? Contact us at <a href="mailto:support@lafriendly.com">support@lafriendly.com</a></p>
</main>
</body>
</html>

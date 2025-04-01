<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lafriendly | You're Invited!</title>
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
  .invitation-message {
    background: #dbeafe;
    padding: 16px;
    border-radius: 8px;
    margin-top: 16px;
    color: #1e40af;
    border-left: 4px solid #3b82f6;
  }
  .group-highlights {
    margin-top: 16px;
    color: #374151;
    text-align: left;
  }
  .group-highlights h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #3b82f6;
  }
  .group-highlights ul {
    list-style: none;
    /* padding-left: 20px; */
    margin-top: 8px;
  }
  .group-highlights li {
    margin-bottom: 4px;
  }
  .cta-button {
    background: #3b82f6;
    color: white;
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 8px;
    margin-top: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.3s;
    border: none;
    cursor: pointer;
    text-decoration: none;
  }
  .cta-button:hover {
    background: #2563eb;
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
  <div>
    <img class="logo" src="https://www.logoai.com/oss/icons/2021/12/02/EoLJeYhT6YPfd26.png" alt="Lafriendly App Logo">
    <!-- <img class="logo" src="{{ asset('images/logo.png') }}" alt="Lafriendly App Logo"> -->
  </div>
  <h2 class="title">You're Invited to <span class="highlight">{{ $group->name }} Group</span>! 🎉</h2>
  <p class="description">Join your friends & meet new people in a fun, engaging social community.</p>
  <div class="invitation-message">
    <p><strong>{{ $user->name }}</strong> you are invited to connect and be part of the conversation. Don’t miss out! 🚀</p>
  </div>
  <div class="group-highlights">
    <h3>What You’ll Get:</h3>
    <ul class="group-highlights-list">
      <li>💬 Exclusive group discussions</li>
      <li>🎥 Fun videos & trending content</li>
      <li>🌎 Meet & interact with new people</li>
      <li>🎉 Exciting events & challenges</li>
    </ul>
  </div>
  <a href="{{ route('groups.show', $group->slug) }}" class="cta-button">Join Now</a>
  <p class="footer">Need help? Contact us at <a href="mailto:support@lafriendly.com">support@lafriendly.com</a></p>
</main>
</body>
</html>

{{-- === Styles UI Feed Simple & Moderne === --}}
<style>
  :root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --primary-hover: #5568d3;
    --bg-main: #f8f9fc;
    --bg-card: #ffffff;
    --border-color: #e4e7eb;
    --text-primary: #1a202c;
    --text-secondary: #4a5568;
    --text-muted: #a0aec0;
    --shadow-sm: 0 2px 8px rgba(102, 126, 234, 0.08);
    --shadow-md: 0 4px 16px rgba(102, 126, 234, 0.12);
    --shadow-lg: 0 8px 24px rgba(102, 126, 234, 0.16);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 24px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    background: var(--bg-main);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: var(--text-primary);
    line-height: 1.6;
  }

  /* === Container === */
  .feed-container {
    max-width: 680px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }

  /* === Create Post Card === */
  .create-post-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    transition: var(--transition);
  }

  .create-post-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
  }

  .create-post-header {
    margin-bottom: 1.5rem;
  }

  .create-post-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .create-post-subtitle {
    font-size: 0.875rem;
    color: var(--text-muted);
  }

  /* === Form Controls === */
  .form-control-custom {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 0.9375rem;
    color: var(--text-primary);
    background: var(--bg-main);
    transition: var(--transition);
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
    line-height: 1.6;
  }

  .form-control-custom:focus {
    outline: none;
    border-color: var(--primary-color);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }

  .form-control-custom::placeholder {
    color: var(--text-muted);
  }

  /* === Button === */
  .btn-primary-custom {
    background: var(--primary-gradient);
    color: #fff;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: var(--radius-md);
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
  }

  .btn-primary-custom:active {
    transform: translateY(0);
  }

  /* === Divider === */
  .divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    margin: 2rem 0;
    border: none;
  }

  /* === Post Card === */
  .post-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    padding: 1.75rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    transition: var(--transition);
    animation: fadeIn 0.4s ease-out;
  }

  .post-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
  }

  /* === Post Header === */
  .post-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.25rem;
  }

  .post-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
  }

  .post-avatar:hover {
    transform: scale(1.08);
    box-shadow: var(--shadow-md);
  }

  .post-author-info {
    flex: 1;
  }

  .post-author-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.125rem;
  }

  .post-meta {
    font-size: 0.8125rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  /* === Post Content === */
  .post-content {
    color: var(--text-secondary);
    font-size: 0.9375rem;
    line-height: 1.7;
    white-space: pre-wrap;
  }

  /* === Post Actions === */
  .post-actions {
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .action-btn {
    background: transparent;
    border: 2px solid var(--border-color);
    color: var(--text-secondary);
    padding: 0.5rem 1.25rem;
    border-radius: var(--radius-xl);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .action-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    background: rgba(102, 126, 234, 0.05);
    transform: translateY(-1px);
  }

  .action-btn svg {
    transition: var(--transition);
  }

  .action-btn:hover svg {
    transform: scale(1.1);
  }

  /* === Empty State === */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    border: 2px dashed var(--border-color);
  }

  .empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.4;
  }

  .empty-state-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
  }

  .empty-state-text {
    color: var(--text-muted);
    font-size: 0.9375rem;
  }

  /* === Badge === */
  .badge-new {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: #fff;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-xl);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* === Animations === */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(12px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes pulse {
    0%, 100% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.05);
    }
  }

  /* === Responsive === */
  @media (max-width: 768px) {
    .feed-container {
      padding: 1rem 0.75rem;
    }

    .create-post-card,
    .post-card {
      padding: 1.5rem;
    }

    .btn-primary-custom {
      width: 100%;
      justify-content: center;
    }

    .post-actions {
      flex-wrap: wrap;
    }

    .action-btn {
      flex: 1;
      min-width: 120px;
      justify-content: center;
    }
  }

  /* === Utilities === */
  .mt-2 { margin-top: 1rem; }
  .mb-0 { margin-bottom: 0; }
</style>

<div class="feed-container">

  {{-- Create Post Section --}}
  <div class="create-post-card">
    <div class="create-post-header">
      <h2 class="create-post-title">
        <svg width="24" height="24" fill="currentColor" style="color: var(--primary-color);" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
        </svg>
        Créer une publication
      </h2>
      <p class="create-post-subtitle">Partagez vos pensées avec la communauté</p>
    </div>

    <form method="POST" action="{{ route('posts.store') }}">
      @csrf
      <textarea 
        name="content" 
        class="form-control-custom" 
        required 
        placeholder="Quoi de neuf ? Écrivez quelque chose d'intéressant..."
      ></textarea>
      
      <button type="submit" class="btn-primary-custom mt-2">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
          <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
        </svg>
        Publier maintenant
      </button>
    </form>
  </div>

  {{-- Divider --}}
  <hr class="divider">

  {{-- Posts Feed --}}
  @forelse($posts as $post)
    <div class="post-card">
      {{-- Post Header --}}
      <div class="post-header">
        <img
          src="{{ $post->user->avatar_path 
                ? asset('storage/'.$post->user->avatar_path) 
                : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&background=667eea&color=fff&bold=true' }}"
          alt="{{ $post->user->name }}"
          class="post-avatar"
        >
        <div class="post-author-info">
          <h3 class="post-author-name">{{ $post->user->name }}</h3>
          <div class="post-meta">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
            </svg>
            <span>{{ $post->created_at->diffForHumans() }}</span>
            @if($post->created_at->diffInHours() < 24)
              <span class="badge-new">Nouveau</span>
            @endif
          </div>
        </div>
      </div>

      {{-- Post Content --}}
      <div class="post-content">
        {{ $post->content }}
      </div>

      {{-- Post Actions --}}
      <div class="post-actions">
        <button class="action-btn">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
          </svg>
          J'aime
        </button>
        <button class="action-btn">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
          </svg>
          Commenter
        </button>
        <button class="action-btn">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
          </svg>
          Partager
        </button>
      </div>
    </div>
  @empty
    {{-- Empty State --}}
    <div class="empty-state">
      <div class="empty-state-icon">📝</div>
      <h3 class="empty-state-title">Aucune publication pour le moment</h3>
      <p class="empty-state-text">Soyez le premier à partager quelque chose !</p>
    </div>
  @endforelse

</div>
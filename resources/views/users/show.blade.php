<x-app-layout>
<div style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); color: #dbe7ff; font-family: 'Manrope', sans-serif; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1000px; margin: 0 auto;">
        <a href="{{ route('users.index') }}" style="display: inline-block; margin-bottom: 1.5rem; color: #ffc500; font-weight: 700; text-decoration: none;">← Retour</a>

        <div style="background: rgba(28, 50, 84, 0.7); border: 1px solid rgba(126, 162, 211, 0.16); padding: 1.5rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <h1 style="margin: 0 0 0.5rem 0; font-size: 1.9rem; font-weight: 800; color: #ffffff;">{{ $user->name }}</h1>
                <button type="button" onclick="copyProfileLink()" style="padding:0.35rem 0.6rem; border-radius:8px; background: rgba(255,197,0,0.12); color:#ffc500; border:1px solid rgba(255,197,0,0.25); font-weight:600; cursor:pointer;">Copier le lien</button>
                <button type="button" onclick="openShareModal()" style="padding:0.35rem 0.6rem; border-radius:8px; background:#2b2b2b; color:#fff; border:1px solid rgba(255,255,255,0.06); font-weight:600; cursor:pointer; margin-left:0.5rem;">Partager</button>
            </div>
            <p style="margin: 0.35rem 0; color: rgb(196, 214, 241, 0.82);"><strong style="color: #ffc500;">Pays:</strong> {{ $user->country->name_country ?? '-' }}</p>
            <p style="margin: 0.35rem 0; color: rgb(196, 214, 241, 0.82);"><strong style="color: #ffc500;">Email:</strong> {{ $user->email }}</p>
            <p style="margin: 0.35rem 0; color: rgb(196, 214, 241, 0.82);"><strong style="color: #ffc500;">Playlists:</strong> {{ $user->playlists->count() }}</p>
        </div>

        @if ($playlists->count() > 0)
            <h2 style="margin: 0 0 1rem 0; font-size: 1.2rem; font-weight: 700; color: #ffffff;">Playlists</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                @foreach ($playlists as $playlist)
                    <div style="background: rgba(28, 50, 84, 0.7); padding: 1rem; border-radius: 14px; border: 1px solid rgba(126, 162, 211, 0.16); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.16);">
                        <h3 style="margin: 0 0 0.5rem 0; color: #ffffff; font-size: 1.05rem;">{{ $playlist->playlist ?? 'Sans titre' }}</h3>
                        <a href="{{ route('playlist', $playlist->id_playlist) }}" style="display: inline-block; margin-top: 0.75rem; color: #ffc500; font-weight: 600; text-decoration: none;">Voir musiques</a>
                    </div>
                @endforeach
            </div>

            @if ($playlists->hasPages())
                <div style="display: flex; justify-content: center; gap: 0.5rem;">
                    {{ $playlists->links() }}
                </div>
            @endif
        @else
            <p style="text-align: center; color: rgb(196, 214, 241, 0.65); padding: 2rem;">{{ $user->name }} n'a pas encore créé de playlist.</p>
        @endif
    </div>
</div>

</x-app-layout>

<script>
async function copyProfileLink() {
    const url = window.location.href;
    try {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            await navigator.clipboard.writeText(url);
            alert('Lien du profil copié dans le presse-papiers.');
        } else {
            // fallback
            prompt('Copiez ce lien manuellement:', url);
        }
    } catch (e) {
        prompt('Copiez ce lien manuellement:', url);
    }
}
</script>

<script>
function shareTest(platform) {
    // Simple test action; no real redirection or API call
    try {
        alert('Test: partage vers ' + platform + '\n(aucune redirection effectuée)');
        console.log('Test share to', platform, 'url=', window.location.href);
    } catch (e) {
        // fallback
        prompt('Test: copier ce lien pour partager vers ' + platform + ':', window.location.href);
    }
}
</script>

<!-- Share modal -->
<div id="shareModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:1200;">
    <div style="width:320px; max-width:90%; margin:6rem auto; background:linear-gradient(105deg,#01060f 0%,#03152d 52%); color:#dbe7ff; border-radius:12px; padding:1rem; box-shadow:0 10px 40px rgba(0,0,0,0.6); border:1px solid rgba(126,162,211,0.08);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
            <strong style="color:#ffc500;">Partager le profil</strong>
            <button type="button" onclick="closeShareModal()" style="background:transparent;border:none;color:#dbe7ff;font-size:1.1rem;cursor:pointer;">✕</button>
        </div>
        <p style="font-size:0.9rem; color:rgb(196,214,241,0.75); margin:0 0 0.75rem 0;">Choisis un réseau pour tester (pas de redirection réelle):</p>
        <div style="display:flex; gap:0.5rem;">
            <button type="button" onclick="shareTest('Facebook'); closeShareModal();" style="flex:1; padding:0.6rem; border-radius:8px; background:#1877F2; color:#fff; border:none; cursor:pointer;">Facebook</button>
            <button type="button" onclick="shareTest('X'); closeShareModal();" style="flex:1; padding:0.6rem; border-radius:8px; background:#1DA1F2; color:#fff; border:none; cursor:pointer;">X</button>
            <button type="button" onclick="shareTest('LinkedIn'); closeShareModal();" style="flex:1; padding:0.6rem; border-radius:8px; background:#0A66C2; color:#fff; border:none; cursor:pointer;">LinkedIn</button>
        </div>
        <div style="margin-top:0.75rem; text-align:right;"><button type="button" onclick="closeShareModal()" style="padding:0.4rem 0.6rem; border-radius:8px; background:transparent; border:1px solid rgba(126,162,211,0.08); color:#dbe7ff; cursor:pointer;">Fermer</button></div>
    </div>
</div>

<script>
function openShareModal(){
    document.getElementById('shareModal').style.display = 'block';
}
function closeShareModal(){
    document.getElementById('shareModal').style.display = 'none';
}
</script>

<section style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); color: #dbe7ff; font-family: 'Manrope', sans-serif; border-radius: 8px; padding: 2rem;">
    <header style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #ffc500; margin: 0;">
            {{ __('Pays') }}
        </h2>
        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: rgb(196, 214, 241, 0.7); margin-bottom: 0;">
            {{ __('Gérez votre pays.') }}
        </p>
    </header>

    <div style="margin-top: 1.5rem;">
        <!-- Pays actuel -->
        <div style="margin-bottom: 2rem; padding: 1.5rem; background: rgba(28, 50, 84, 0.5); border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.2);">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #ffc500; margin: 0 0 1rem 0;">Pays actuel</h3>

            @if ($user->country)
                <div style="padding: 1rem; background: rgba(28, 50, 84, 0.3); border-radius: 6px; border-left: 3px solid #ffc500; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-size: 1rem; color: #dbe7ff; font-weight: 600;">{{ $user->country->name_country }}</p>
                    </div>
                    <form action="{{ route('profile.country.delete') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Mettre le pays en N/A ?')"
                            style="padding: 0.5rem 1rem; font-size: 0.85rem; background: #ff7a7a; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                            Supprimer
                        </button>
                    </form>
                </div>
            @else
                <p style="text-align: center; color: rgb(196, 214, 241, 0.6); padding: 1.5rem; font-style: italic;">Aucun pays sélectionné</p>
            @endif
        </div>

        <!-- Changer le pays -->
        <div style="margin-bottom: 2rem; padding: 1.5rem; background: rgba(28, 50, 84, 0.5); border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.2);">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #ffc500; margin: 0 0 1rem 0;">Changer le pays</h3>
            <form action="{{ route('profile.country.update') }}" method="POST" style="display: grid; gap: 1rem;">
                @csrf

                <div>
                    <label for="id_country" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Sélectionner un pays</label>
                    <select name="id_country" id="id_country"
                        style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;"
                        required>
                        <option value="">-- Choisir un pays --</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id_country }}" {{ $user->id_country === $country->id_country ? 'selected' : '' }}>
                                {{ $country->name_country }} {{-- Affiche le nom du pays dans la liste déroulante --}}
                            </option>
                        @endforeach
                    </select>
                    @error('id_country')
                        <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" style="padding: 0.75rem 1.5rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; font-size: 0.95rem; align-self: flex-start;">
                    Enregistrer
                </button>

                @if (session('status') === 'country-updated')
                    <p style="margin: 0; font-size: 0.9rem; color: #45b071;">
                        {{ __('Pays mise à jour.') }}
                    </p>
                @endif
            </form>
        </div>
    </div>
</section>

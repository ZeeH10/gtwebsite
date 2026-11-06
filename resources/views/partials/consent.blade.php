{{-- POPIA consent checkbox, required on every form that collects personal information --}}
<div>
    <label class="flex cursor-pointer items-start gap-3">
        <input type="checkbox" name="consent" value="1" required @checked(old('consent'))
               class="mt-1 size-5 shrink-0 rounded border-slate-300 accent-royal-700" @error('consent') aria-invalid="true" aria-describedby="consent-error" @enderror>
        <span>I agree that Glad Tidings Fellowship Bethel Centre may keep the details I give here to {{ $purpose }}, as explained in the <a href="{{ route('privacy') }}" class="link" target="_blank">privacy notice</a>.</span>
    </label>
    @error('consent') <p id="consent-error" class="mt-1.5 text-sm text-cross-600">{{ $message }}</p> @enderror
</div>

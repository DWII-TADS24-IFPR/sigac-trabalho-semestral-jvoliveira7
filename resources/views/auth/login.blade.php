<x-guest-layout>
  <div class="min-h-screen bg-gradient-to-tr from-blue-100 to-indigo-200 flex items-start justify-center py-20 px-10">
    <div class="w-[400px] bg-white rounded-xl shadow-lg p-10 border border-gray-200">
      
      <h2 class="text-4xl font-extrabold text-indigo-700 mb-8 text-left">
        Bem-vindo ao Sigac!
      </h2>

      <!-- Erros -->
      <x-input-error :messages="$errors->all()" class="mb-6" />

      <form method="POST" action="{{ route('login') }}" class="space-y-8">
        @csrf

        <div>
          <x-input-label for="email" :value="'Email'" class="block text-base font-semibold text-gray-800 mb-2" />
          <x-text-input id="email" class="block w-full rounded border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" type="email" name="email"
            :value="old('email')" required autofocus placeholder="seuemail@exemplo.com" />
        </div>

        <div>
          <x-input-label for="password" :value="'Senha'" class="block text-base font-semibold text-gray-800 mb-2" />
          <x-text-input id="password" class="block w-full rounded border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" type="password" name="password"
            required autocomplete="current-password" placeholder="********" />
        </div>

        <div class="flex items-center">
          <input id="remember_me" type="checkbox"
            class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
            name="remember">
          <label for="remember_me" class="ml-3 block text-sm text-gray-700 select-none">
            Lembre-se de mim
          </label>
        </div>

        <div>
          <x-primary-button
            class="w-full py-3 text-white font-semibold bg-indigo-700 rounded shadow hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition duration-150">
            INICIAR SESSÃO
          </x-primary-button>
        </div>
      </form>

      <p class="mt-8 text-left text-sm text-gray-600">
        Não tem uma conta?
        <a href="{{ route('register') }}" class="font-semibold text-indigo-700 hover:text-indigo-900 underline">
          Cadastre-se como Aluno
        </a>
      </p>
    </div>
  </div>
</x-guest-layout>

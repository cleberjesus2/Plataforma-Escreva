@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl text-gray-800">
    <!-- Botão de voltar -->
    <div class="mb-4">
        <button onclick="history.back()" class="flex items-center text-gray-600 hover:text-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-sm">Voltar</span>
        </button>
    </div>

    <!-- Título -->
    <div class="text-center mb-6 px-2">
        <h1 class="text-2xl sm:text-3xl font-bold text-green-700 break-words">{{ $tema['titulo'] }}</h1>
        <p class="text-sm sm:text-base text-gray-600">Proposta de redação para treino em casa</p>
    </div>

    <!-- Descrição -->
    <div class="bg-white p-4 sm:p-6 rounded-md shadow mb-6">
        <h2 class="text-base sm:text-lg font-semibold mb-2">Descrição da Função</h2>
        <p class="text-sm sm:text-base text-gray-700">
            Com base nos textos motivadores e nos seus próprios conhecimentos, redija um texto dissertativo-argumentativo sobre o tema <strong>{{ $tema['titulo'] }}</strong> em norma-padrão da língua portuguesa.
        </p>
    </div>

    <!-- Imagem do tema -->
    <div class="mb-6">
        <img src="{{ asset('images/temas/' . $tema['imagem']) }}"
             onerror="this.onerror=null; this.src='{{ asset('images/temas/default.jpg') }}';"
             alt="Imagem do tema {{ $tema['titulo'] }}"
             class="w-full h-auto max-h-[400px] object-contain rounded-md border shadow mx-auto">
    </div>

    <!-- Textos motivadores -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        @foreach ($tema['textos'] as $index => $texto)
            <div class="bg-gray-100 p-4 rounded-md border-l-4 border-green-600 shadow-sm">
                <h3 class="font-semibold mb-2">Texto Motivador {{ $index + 1 }}</h3>
                <p class="text-sm text-gray-700 whitespace-pre-line break-words">{{ $texto }}</p>
            </div>
        @endforeach
    </div>



    <!-- Botão para iniciar -->
    <div class="text-center mb-6">
        <button onclick="iniciarSimulado()" class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition text-sm sm:text-base">
            📝 Começar Redação
        </button>
    </div>

    <!-- Timer -->
   <!-- Botões de controle do timer -->
<div id="timerContainer" class="text-center hidden mb-6">
    <p class="text-lg font-semibold">⏳ Tempo: <span id="timer">00:00</span></p>
    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-4">
        <button onclick="pausarOuRetomarTimer()" id="btnPausar" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
            Pausar
        </button>
        <button onclick="finalizarSimulado()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
            Finalizar
        </button>
    </div>
</div>

<!-- Modal Finalização -->
<div id="modalFinalizacao" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 max-w-md text-center">
        <h3 class="text-lg font-semibold mb-4">Simulado Finalizado</h3>
        <p class="mb-4">⏱️ Tempo total: <span id="tempoTotalModal" class="font-mono font-bold text-green-700"></span></p>
        <button onclick="fecharModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Fechar
        </button>
    </div>
</div>

<!-- Script corrigido -->
<script>
    let tempo = 0;
    let timerAtivo = false;
    let timerInterval = null;

    function iniciarSimulado() {
        if (timerInterval) return;

        timerAtivo = true;
        document.getElementById("timerContainer").classList.remove("hidden");

        timerInterval = setInterval(() => {
            if (timerAtivo) {
                tempo++;
                atualizarTimer();
            }
        }, 1000);
    }

    function atualizarTimer() {
        let minutos = String(Math.floor(tempo / 60)).padStart(2, '0');
        let segundos = String(tempo % 60).padStart(2, '0');
        document.getElementById("timer").textContent = `${minutos}:${segundos}`;
    }

    function pausarOuRetomarTimer() {
        timerAtivo = !timerAtivo;
        const btn = document.getElementById("btnPausar");
        btn.textContent = timerAtivo ? "Pausar" : "Retomar";
        btn.classList.toggle("bg-yellow-500", timerAtivo);
        btn.classList.toggle("bg-blue-500", !timerAtivo);
    }

    function finalizarSimulado() {
        clearInterval(timerInterval);
        atualizarTimer();

        document.getElementById("tempoTotalModal").textContent = document.getElementById("timer").textContent;
        document.getElementById("modalFinalizacao").classList.remove("hidden");

        // Resetar estado
        timerInterval = null;
        tempo = 0;
        timerAtivo = false;
        document.getElementById("timer").textContent = "00:00";
        document.getElementById("btnPausar").textContent = "Pausar";
        document.getElementById("btnPausar").classList.add("bg-yellow-500");
        document.getElementById("btnPausar").classList.remove("bg-blue-500");
        document.getElementById("timerContainer").classList.add("hidden");
    }

    function fecharModal() {
        document.getElementById("modalFinalizacao").classList.add("hidden");
    }
</script>

@endsection

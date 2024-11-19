import { useEffect, useRef } from 'react';

export const MainLayout = ({ currentSong, isPlaying, analyser, dataArray }) => {
    const canvasRef = useRef(null);

    useEffect(() => {
        if (!analyser || !dataArray) return;

        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;

        const baseRadius = 150; // Radio base de las barras
        const innerRadius = 100; // Radio del agujero central

        const draw = () => {
            if (!isPlaying) return;

            analyser.getByteFrequencyData(dataArray);
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const bars = 120; // Número de barras en el círculo
            const angleIncrement = (2 * Math.PI) / bars;

            for (let i = 0; i < bars; i++) {
                // Escalado para mayor sensibilidad pero limitando la longitud máxima
                const barHeight = Math.min(dataArray[i] * 0.3, 80); // Ajusta 0.3 y 80 según tus necesidades

                // Solo dibujar líneas si barHeight es mayor que un umbral
                if (barHeight > 5) {
                    const angle = i * angleIncrement;

                    const x1 = centerX + innerRadius * Math.cos(angle);
                    const y1 = centerY + innerRadius * Math.sin(angle);
                    const x2 = centerX + (baseRadius + barHeight) * Math.cos(angle);
                    const y2 = centerY + (baseRadius + barHeight) * Math.sin(angle);

                    // Gradiente de color para cada barra
                    const gradient = ctx.createLinearGradient(x1, y1, x2, y2);
                    gradient.addColorStop(0, `rgb(50, 100, ${barHeight + 150})`);
                    gradient.addColorStop(1, `rgb(255, 70, ${barHeight + 100})`);

                    ctx.strokeStyle = gradient;
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.moveTo(x1, y1);
                    ctx.lineTo(x2, y2);
                    ctx.stroke();
                }
            }

            requestAnimationFrame(draw);
        };

        draw();

        return () => cancelAnimationFrame(draw);
    }, [analyser, dataArray, isPlaying]);

    return (
        <div className="w-2/4 p-6 bg-gris-spotify text-white rounded-lg shadow-lg flex flex-col items-center">
            <h2 className="text-2xl font-bold mb-4 text-center">EQUALIZADOR</h2>
            {currentSong ? (
                <div className="flex flex-col items-center">
                    <p className="text-lg">{currentSong.titulo}</p>
                    <p className="text-sm text-gray-400">{currentSong.artista}</p>
                    <canvas
                        ref={canvasRef}
                        width={400}
                        height={400}
                        className="mt-4 bg-black rounded-full border-4 border-gray-700 shadow-xl"
                    />
                </div>
            ) : (
                <p>No song selected</p>
            )}
        </div>
    );
};

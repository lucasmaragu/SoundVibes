import { useState } from 'react';

export const InfoArtista = ({ song, changeHighshelfGain }) => {
    const [highshelfGain, setHighshelfGain] = useState(0); // Estado local para el control de agudos

    const handleHighshelfChange = (e) => {
        const newGain = parseFloat(e.target.value);
        setHighshelfGain(newGain);
        changeHighshelfGain(newGain); // Cambia los agudos en el reproductor
    };

    return (
        <div className="w-1/4 p-4 rounded-lg bg-gris-spotify-oscuro">
            {song ? (
                <div className="flex flex-col items-start">
                    <img className="mt-4 rounded-lg w-full mx-auto" src={song.portada} alt={song.titulo} />
                    <div className="mt-2 flex justify-between items-center w-full">
                        <div>
                            <h1 className="text-[30px] text-white font-bold">{song.titulo}</h1>
                            <h2 className="text-[18px] text-gris-texto font-medium">{song.artista}</h2>
                        </div>
                        <img src="/assets/like.png" alt="heart icon" className="w-5 h-5" />
                    </div>
                    {/* Control de Agudos */}
                    <div className="mt-4 w-full">
                        <label className="text-sm text-white font-medium">Control de Agudos</label>
                        <input
                            type="range"
                            min="-20"
                            max="20"
                            step="1"
                            value={highshelfGain}
                            onChange={handleHighshelfChange}
                            className="w-full mt-1"
                        />
                    </div>
                </div>
            ) : (
                <h1 className="text-lg font-bold text-white">Selecciona una canción</h1>
            )}
        </div>
    );
};

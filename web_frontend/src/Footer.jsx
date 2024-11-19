import { useState } from 'react';

export const Footer = ({ 
  song, 
  isPlaying, 
  play, 
  pause, 
  prev, 
  next, 
  currentTime, 
  duration, 
  seek, 
  changeVolume 
}) => {
  const [volume, setVolume] = useState(1); // Estado para el volumen (0 a 1)

  const formatTime = (time) => {
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);
    return `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
  };
  
  const handleSeek = (e) => {
    const newTime = parseFloat(e.target.value);
    seek(newTime);
  };

  const handleVolumeChange = (e) => {
    const newVolume = parseFloat(e.target.value);
    setVolume(newVolume);
    changeVolume(newVolume); // Cambiar el volumen en el reproductor
  };

  return (
    <footer className="w-full h-20 flex items-center bg-black text-white">
      {song ? (
        <>
          <div className="p-4">
            <img src={song.portada} alt={song.titulo} className="w-12 h-12 rounded-sm" />
          </div>
          <div className="flex flex-col">
            <h1 className="text-md font-bold">{song.titulo}</h1>
            <h3 className="text-sm font-semibold">{song.artista}</h3>
          </div>
          <div className="flex flex-grow justify-center items-center">
            <div className="flex justify-center items-center gap-6">
              <button onClick={prev}>
                <img className="w-4 h-4" src="/assets/prev.png" alt="Previous" />
              </button>
              <button onClick={() => (isPlaying ? pause() : play())}>
                {isPlaying ? (
                  <img className="w-4 h-4" src="/assets/pause.png" alt="Pause" />
                ) : (
                  <img className="w-4 h-4" src="/assets/play.png" alt="Play" />
                )}
              </button>
              <button onClick={next}>
                <img className="w-4 h-4" src="/assets/next.png" alt="Next" />
              </button>
            </div>
            <div className="flex flex-col items-center w-1/4 mt-4">
              <span>{formatTime(currentTime)} / {formatTime(duration)}</span>
              <input
                type="range"
                min="0"
                max={duration}
                value={currentTime}
                onChange={handleSeek}
                className="w-full"
              />
            </div>
            <div className="flex flex-col items-center w-1/4 mt-4">
              <span className="text-sm">Volumen</span>
              <input
                type="range"
                min="0"
                max="1"
                step="0.01"
                value={volume}
                onChange={handleVolumeChange} // Cambiar el volumen en el reproductor
                className="w-full"
              />
            </div>
          </div>
        </>
      ) : (
        <div className="flex-grow text-center">
          <h3 className="text-md">Selecciona una canción para reproducir</h3>
        </div>
      )}
    </footer>
  );
};

export default Footer;

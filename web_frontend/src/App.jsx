import React, { useState, useEffect } from 'react';
import { Header } from './Header';
import { PlayList } from './PlayList';
import { Footer } from './Footer';
import { MainLayout } from './MainLayout';
import { InfoArtista } from './InfoArtista';
import { songs } from './data/songs';
import { useHowler } from './hooks/useHowler';

const App = () => {
  const [mood, setMood] = useState('Feliz'); // Estado de ánimo inicial
  const [selectedSong, setSelectedSong] = useState(null); // Inicia en null para mostrar el mensaje en Footer
  const {
    sound,
    play,
    pause,
    isPlaying,
    prev,
    next,
    currentSongIndex,
    currentTime,
    duration,
    seek,
    analyser,
    dataArray,
    changeVolume,
    changeHighshelfGain,
  } = useHowler(selectedSong ? selectedSong.src : null, songs);

  const getSongsByMood = (mood) => {
    return songs.canciones.filter((song) => song.mood.toLowerCase() === mood.toLowerCase());
  };

  const handleMoodChange = (newMood) => {
    setMood(newMood);
  };
  const handleSongSelect = (song) => {
    setSelectedSong(song);
    console.log("Canción seleccionada:", song.titulo);
  };

  // Sobreescribe la función play para que seleccione la primera canción si selectedSong es null
  const handlePlay = () => {
    if (!selectedSong) {
      // Selecciona la primera canción si no hay ninguna canción seleccionada
      setSelectedSong(songs.canciones[0]);
    }
    play(); // Reproduce la canción
  };

  useEffect(() => {
    if (currentSongIndex >= 0 && currentSongIndex < songs.canciones.length) {
      const song = songs.canciones[currentSongIndex];
      setSelectedSong(song);
      console.log("Canción actualizada:", song.titulo);
    }
  }, [currentSongIndex]);

  return (
    <div className="flex flex-col bg-black min-h-screen">
     <Header mood={mood} onMoodChange={handleMoodChange} />
      <div className="flex flex-grow gap-4">
        <PlayList mood={mood} onSongSelect={handleSongSelect} getSongsByMood={getSongsByMood}/>
        <MainLayout 
          currentSong={songs.canciones[currentSongIndex]} 
          isPlaying={isPlaying} 
          analyser={analyser} 
          dataArray={dataArray} 
        />
        <InfoArtista song={selectedSong} changeHighshelfGain={changeHighshelfGain}/>
      </div>
      <Footer 
        song={selectedSong} 
        isPlaying={isPlaying} 
        play={handlePlay}  // Utiliza handlePlay en lugar de play
        pause={pause} 
        prev={prev} 
        next={next} 
        currentTime={currentTime} 
        duration={duration}
        seek={seek}
        changeVolume={changeVolume} 
      />
    </div>
  );
};

export default App;
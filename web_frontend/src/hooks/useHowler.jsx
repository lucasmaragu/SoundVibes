import { Howl } from 'howler';
import { useEffect, useState } from 'react';

export const useHowler = (initialSrc, songs) => {
    const [sound, setSound] = useState(null);
    const [isPlaying, setIsPlaying] = useState(false);
    const [currentSongIndex, setCurrentSongIndex] = useState(0);
    const [currentTime, setCurrentTime] = useState(0);
    const [duration, setDuration] = useState(0);
    const [analyser, setAnalyser] = useState(null);
    const [dataArray, setDataArray] = useState(null);
    const [volume, setVolume] = useState(1);
    const [highshelfGain, setHighshelfGain] = useState(0);
    
    useEffect(() => {
        let newSound = null;
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const analyserNode = audioContext.createAnalyser();
        analyserNode.fftSize = 2048;
        const bufferLength = analyserNode.frequencyBinCount;
        const newDataArray = new Uint8Array(bufferLength);
        setDataArray(newDataArray);
        setAnalyser(analyserNode);

        if (initialSrc) {
            if (sound) {
                sound.stop();
            }

            newSound = new Howl({
                src: [initialSrc],
                html5: true,
                volume: volume,
                onplay: () => setIsPlaying(true),
                onend: () => setIsPlaying(false),
                onpause: () => setIsPlaying(false),
                onstop: () => setIsPlaying(false),
                onload: () => { setDuration(newSound.duration()); },
            });

            setSound(newSound);
            newSound.play();

            const highshelfFilter = audioContext.createBiquadFilter();
            highshelfFilter.type = "highshelf";
            highshelfFilter.frequency.value = 3000;
            highshelfFilter.gain.value = highshelfGain;

            const sourceNode = audioContext.createMediaElementSource(newSound._sounds[0]._node);
            sourceNode.connect(highshelfFilter);
            highshelfFilter.connect(analyserNode);
            analyserNode.connect(audioContext.destination);

            return () => {
                newSound.stop();
                setSound(null);
            };
        }
    }, [initialSrc, highshelfGain]); // Añadir `highshelfGain` para que el filtro se actualice cuando cambie

    useEffect(() => {
        if (sound) {
            sound.volume(volume);
        }
    }, [volume, sound]);

    const play = () => {
        if (sound) {
            sound.play();
        }
    };

    const pause = () => {
        if (sound) {
            sound.pause();
        }
    };

    const next = () => {
        const newIndex = (currentSongIndex + 1) % songs.canciones.length;
        loadSong(newIndex);
    };

    const prev = () => {
        const newIndex = (currentSongIndex - 1 + songs.canciones.length) % songs.canciones.length;
        loadSong(newIndex);
    };

    useEffect(() => {
        let intervalId;
        if (isPlaying && sound) {
            intervalId = setInterval(() => {
                setCurrentTime(sound.seek());
            }, 1000);
        }
        return () => clearInterval(intervalId);
    }, [isPlaying, sound]);

    const changeHighshelfGain = (value) => {
        setHighshelfGain(value);
    };

    const loadSong = (index) => {
        if (songs.canciones[index]) {
            if (sound) {
                sound.stop();
                sound.unload();
            }
            setCurrentSongIndex(index);
            const newSrc = songs.canciones[index].src;
            const newSound = new Howl({
                src: [newSrc],
                html5: true,
                onload: () => {
                    setDuration(newSound.duration());
                },
                onplay: () => {
                    setIsPlaying(true);
                },
                volume: volume,
            });

            setSound(newSound);
            newSound.play();
        }
    };

    const seek = (time) => {
        if (sound) {
            sound.seek(time);
            setCurrentTime(time);
        }
    };

    const changeVolume = (newVolume) => {
        setVolume(newVolume);
        if (sound) {
            sound.volume(newVolume);
        }
    };

    return {
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
        volume,
        changeVolume,
        highshelfGain,
        changeHighshelfGain,
    };
};

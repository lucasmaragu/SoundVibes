import { useState, useEffect } from 'react';
import { useHowler } from '../hooks/useHowler';


export const Radio = () => {
   const [radios, setRadios] = useState([]);
   const [selectedRadio, setSelectedRadio] = useState(null);
   const { play, pause, stop, isPlaying } = useHowler(selectedRadio?.src);

   useEffect(() =>  {
    const fetchRadios = async () => {
      const response = await fetch('http://172.17.131.175:3000/api/radios');
      const data = await response.json();
      setRadios(data.radios);
    }
    fetchRadios();

}, []);


const handleSelectRadio = (radio) => {
  console.log(radio.tittle)
  if (isPlaying()) {
      stop(); // Detener la radio actual
  }
  setSelectedRadio(radio); // Actualizar la radio seleccionada
};

  
  return (
    <div>
      <h1>Radio Player</h1>
      <ul>
        {radios.map((radio) => (
          <li key={radio.id}>
            <button onClick={() => handleSelectRadio(radio)}>
              {radio.tittle} ({radio.frequency} MHz)
            </button>
          </li>
        ))}
      </ul>
      <div>
        {/*
        <button onClick={play} disabled={isPlaying() || !selectedRadio}>Play</button>
        <button onClick={pause} disabled={!isPlaying()}>Pause</button>
        <button onClick={stop} disabled={!isPlaying()}>Stop</button>*/}
      </div>
    </div>
  );
}


export const PlaylistCard = ({ imagen, titulo, subtitulo, onClick }) => {
  return (
    <button className="px-2 py-2 flex items-start hover:bg-gris-spotify" onClick={onClick}>
      <div className="w-12 h-12  mr-3">
        <img src={imagen} alt={titulo} className="w-full h-full" />
      </div>
      <div className="flex flex-col mt-2">
        <h1 className="text-sm text-white text-left">{titulo}</h1>
        <h3 className="text-xs text-gris-texto text-left">{subtitulo}</h3>
      </div>
    </button>
  );
};

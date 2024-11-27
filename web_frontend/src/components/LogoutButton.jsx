export const LogoutButton = () => {

    const handleRedirect = () => {
        window.location.href = "http://localhost:8000/logout.php";
      };


  return (
    <div>
      <button className="bg-red-700 rounded-lg p-2 hover:bg-red-950 font-bold " onClick={handleRedirect}>Cerrar Sesión</button>
    </div>
  );
};

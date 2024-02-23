import React from 'react';

const Home = () => {
  const onClick = async () => {
    const response = await fetch('http://127.0.0.1:8000/api/home');
    const jsonData = await response.json();
    console.log(jsonData);
  };
  return (
    <div onClick={onClick}>
      Hello world
    </div>
  );
}

export default Home;

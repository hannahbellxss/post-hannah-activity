import React from 'react';

function Button() {
  const handleClick = () => {
    alert('Miss u');
  };

  return (
    <button onClick={handleClick}>
      Pindutin mo here
    </button>
  );
}

export default Button;
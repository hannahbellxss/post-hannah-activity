
import { useState } from "react";
import Card from "./component/ui/Card";
import Form from "./component/ui/Form";
import PostCard from "./component/ui/PostCard";
import Post from "./component/ui/Post";


function App() {
  const [count, setCount] = useState(0);

  const users = [
    "Leanne Graham",
    "Ervin Howell",
    "Clementine Bauch",
    "Patricia Lebsack",
    "Chelsey Dietrich",
    "Mrs. Dennis Schulist",
    "Kurtis Weissnat",
    "Nicholas Runolfsdottir",
    "Glenna Reichert",
    "Clementina DuBuque"
  ];

  return (
    <>
      <h1>Haloo, React</h1>

      <button onClick={() => alert("Hello React!")}>
        Click
      </button>

      <Card
        name="Shai"
        description="This is my friend"
      />

      <button onClick={() => setCount(count + 1)}>
        Count {count}
      </button>

      <Form />

      <ul>
        {users.map((user, index) => (
          <li key={index}>{user}</li>
        ))}
      </ul>
            <Post />
    </>
  );
}

export default App;

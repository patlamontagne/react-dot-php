export default function Introduction({ title, cat, dog, food }) {
    return (
        <div>
            <h1>{title}</h1>
            <ul>
                <li>I like my cat {cat}</li>
                <li>I love my dog {dog}</li>
                <li>My favorite food is {food}!</li>
            </ul>
        </div>
    );
}

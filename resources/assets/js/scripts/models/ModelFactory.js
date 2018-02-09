import Article from "./Article";
import Contact from "./Contact";
import Content from "./Content";
import Doctor from "./Doctor";
import News from "./News";
import Skill from "./Skill";
import Tag from "./Tag";
import User from "./User";
import Bug from "./Bug";

export default class ModelFactory{
    static newInstance(className, ...args){
        if(typeof className === 'object')
            className = className.constructor.name;
        else if(typeof className === 'function')
            className = className.name;

        if(className === "Article")
            return new Article(...args);
        else if(className === "Contact")
            return new Contact(...args);
        else if(className === "Content")
            return new Content(...args);
        else if(className === "Doctor")
            return new Doctor(...args);
        else if(className === "News")
            return new News(...args);
        else if(className === "Skill")
            return new Skill(...args);
        else if(className === "Tag")
            return new Tag(...args);
        else if(className === "User")
            return new User(...args);
        else if(className === "Bug")
            return new Bug(...args);
    }

    static buildOrNull(className, json) {
        return json && json.id ? ModelFactory.newInstance(className, json) : null;
    }
}
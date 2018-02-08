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
    static newInstance(classname, ...args){
        if(typeof classname === 'object')
            classname = classname.constructor.name;
        else if(typeof classname === 'function')
            classname = classname.name;

        if(classname === "Article")
            return new Article(...args);
        else if(classname === "Contact")
            return new Contact(...args);
        else if(classname === "Content")
            return new Content(...args);
        else if(classname === "Doctor")
            return new Doctor(...args);
        else if(classname === "News")
            return new News(...args);
        else if(classname === "Skill")
            return new Skill(...args);
        else if(classname === "Tag")
            return new Tag(...args);
        else if(classname === "User")
            return new User(...args);
        else if(classname === "Bug")
            return new Bug(...args);
    }

    static buildOrNull(classname, json) {
        return json && json.id ? ModelFactory.newInstance(classname, json) : null;
    }
}
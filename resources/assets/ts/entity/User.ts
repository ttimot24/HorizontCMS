import { UserRole } from "./UserRole";

export interface User {

    id: number,
    name: string;
    username: string,
    email: string;
    image: string;
    api_token: string;
    role: UserRole;
    
}
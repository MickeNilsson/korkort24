// Node modules
import {Button} from 'react-bootstrap';
import SignUpPage from '../pages/SignUpPage';

export default function SignUpPageButton({setPage}) {

    return (
        
        <Button 
            onClick={() => setPage(<SignUpPage />)}
            size='sm'
            variant='success'>Skapa konto</Button>
    );
}
// Node modules
import axios from 'axios';
import {Card, Form} from 'react-bootstrap';
import {useState} from 'react';

// Components
import EmailField from '../inputfields/EmailField';
import LoginButton from '../buttons/LoginButton';
import PasswordField from '../inputfields/PasswordField';
import StudentAccountPage from './StudentAccountPage';
import AdminPage from './AdminPage';

export default function LoginPage({setPage, student, setStudent}) {

    const [AwaitingLogInResponse, setAwaitingLogInResponse] = useState(false);

    const [email, setEmail] = useState('');

    const [emailFieldIsValid, setEmailFieldIsValid] = useState(false);

    const [password, setPassword] = useState('');

    const [passwordFieldIsValid, setPasswordFieldIsValid] = useState(false);

    const [responseErrorMessage, setResponseErrorMessage] = useState('');

    const [showValidation, setShowValidation] = useState(false);

    function handleSubmit(event_o) {
       
        event_o.preventDefault();
        
        event_o.stopPropagation();

        if(emailFieldIsValid && email === 'admin@korkort24.com' && passwordFieldIsValid && password === 'Pass123') {

            setPage(<AdminPage />);
            
            return;
        
        } else if(emailFieldIsValid) {

            setAwaitingLogInResponse(true);

            axios.post('https://körkort24.com/api/login/', {
                email: email,
                password: password,
                type: 'student'
              })
              .then(function (response_o) {
                
                if(response_o.status === 200) {
                   
                    setStudent(response_o.data[0]);
                    
                    setPage(<StudentAccountPage student={response_o.data[0]} />);
                } else {

                    setAwaitingLogInResponse(false);

                    setResponseErrorMessage('E-postadressen eller lösenordet är fel.');
                }
              })
              .catch(function (error_o) {

                setAwaitingLogInResponse(false);

                switch(error_o.response.status) {

                    case 500: setResponseErrorMessage('E-postadressen eller lösenordet är fel.'); break;
                }
              });
        }
        
        setShowValidation(true);
    }

    return (     
           
        <Card className='login-card'>

            <Card.Body>

                <Card.Text><small>Logga in med e-postadress & lösenord</small></Card.Text>

                <Form
                    noValidate
                    onSubmit={handleSubmit}>

                    <EmailField 
                        disabled={AwaitingLogInResponse}
                        isValid={emailFieldIsValid}
                        setEmail={setEmail} 
                        setIsValid={setEmailFieldIsValid}
                        showValidation={showValidation} />

                    <PasswordField 
                        disabled={AwaitingLogInResponse}
                        isValid={passwordFieldIsValid} 
                        setIsValid={setPasswordFieldIsValid}
                        setPassword={setPassword}
                        showValidation={showValidation} />

                    <LoginButton disabled={!emailFieldIsValid || !passwordFieldIsValid || AwaitingLogInResponse} />

                    <small className='text-danger'>{responseErrorMessage}</small>

                </Form>
                
            </Card.Body>

        </Card>        
    );
}
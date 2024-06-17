// Node modules
import {useEffect, useRef, useState} from 'react';
import {Container} from 'react-bootstrap';

// Components
import Footer from './components/Footer';
import MainContent from './components/MainContent';
import TopMenu from './components/TopMenu';

// Pages
import StartPage from './components/pages/StartPage';

export default function App() {

    const [page, setPage] = useState(null);

    const [student, setStudent] = useState(null);

    const hasInitialised = useRef(false);

    useEffect(() => {

        if(!hasInitialised.current) {

            hasInitialised.current = true;
           
            setPage(<StartPage setPage={setPage} setStudent={setStudent} />);
        }
        
    }, []);

    return (

        <>
            <TopMenu student={student} setStudent={setStudent} page={page} setPage={setPage} />

            <MainContent page={page} setPage={setPage} />
            
            <Footer />
        </>
    );
}
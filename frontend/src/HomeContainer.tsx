import React, {useEffect} from 'react';
import {useDispatch, useSelector} from 'react-redux';
import {changeToken, selectToken} from './slice/sessionSlice';
import HomeScreen from './HomeScreen';
import axios from 'axios';

export default function HomeContainer() {
  const token = useSelector(selectToken);
  const dispatch = useDispatch();

  useEffect(() => {
    if (token !== null) return;

    const intervalId = setInterval(() => {
      if (token) clearInterval(intervalId);
      axios
        .get('/api/session.php')
        .then(response => {
          console.log(response.data);
          if (token == null) dispatch(changeToken(response.data.token));
          clearInterval(intervalId);
        })
        .catch(error => {
          console.log(error);
        });
    }, 2500);

    return () => clearInterval(intervalId);
  }, []);

  return <HomeScreen gotoEventCreation={() => {}} />;
}

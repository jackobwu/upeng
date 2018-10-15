import Route from 'vue-routisan';
import { auth, guest } from './guards';
import Signup from '../views/Auth/Signup';
import Signin from '../views/Auth/Signin';
import Home from '../views/Home';
import Friends from '../views/Friends';
import Show from '@/views/Profile/Show';
import SearchResults from '../views/SearchResults';
import Change from '@/views/Auth/Passwords/Change';
import Edit from '@/views/Profile/Edit';
import Email from '@/views/Auth/Passwords/Email';
import Reset from '@/views/Auth/Passwords/Reset';
import Error from '@/views/Errors/Error';

Route.view('/', Home);

Route.view('/user/:username', Show);

Route.group({ guard: guest }, () => {
    Route.view('/signup', Signup);

    Route.view('/signin', Signin);

    Route.view('/password/reset', Email);

    Route.view('/password/reset/:token', Reset);
});

Route.group({ guard: auth }, () => {
    Route.view('/profile/edit', Edit);

    Route.view('/password/change', Change);

    Route.view('/friends', Friends);

    Route.view('/search', SearchResults); 

    
});

Route.view('*', Error);

export default Route.all();
const { registerPlugin } = wp.plugins;
 
import Exclusion_Meta from './exclusionMeta';
 
registerPlugin( 'wp-analytify', {
	render() {
		return(<Exclusion_Meta />);
	}
} );
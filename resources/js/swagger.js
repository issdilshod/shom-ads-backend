import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';

SwaggerUI({
    dom_id: '#swagger-api',
    url: 'http://localhost/shom/ads/backend/public/api.yaml?v=0.1',
});
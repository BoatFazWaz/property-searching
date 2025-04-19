# Answers to Technical Questions

## How long did you spend on the coding test? What additional features would you consider implementing if you had more time?

I spent approximately 3 hours on this coding test. If I had more time, I would consider implementing the following additional features:

1. **Advanced Filtering**: More detailed filtering options such as price range, number of bedrooms, property type, and area size.
2. **Property Detail Page**: A dedicated page for each property with more photos, detailed descriptions, and features.
3. **Map Integration**: Adding a map view showing property locations with Google Maps or OpenStreetMap.
4. **Favorites/Saved Properties**: Allow users to save properties they're interested in.
5. **Similar Properties**: Show similar properties based on location, price, or property type.
6. **Mobile App**: Converting the solution into a Progressive Web App (PWA) for better mobile experience.
7. **Performance Optimizations**: Implementing caching strategies, lazy loading of images, and code splitting for better performance.
8. **Multi-language Support**: Adding support for Thai language in addition to English.

## Describe a security best practice you would implement in this application to protect the API.

To protect the API, I would implement JWT (JSON Web Token) authentication with proper token validation and refresh mechanisms. This would include:

1. **Rate Limiting**: Implementing rate limiting to prevent abuse and DDoS attacks.
2. **Input Validation**: Thorough validation of all input data to prevent SQL injection and XSS attacks.
3. **CORS Policies**: Strict CORS (Cross-Origin Resource Sharing) policies to control which domains can access the API.
4. **API Versioning**: Implementing proper API versioning to ensure backward compatibility.
5. **HTTPS Enforcement**: Ensuring all API traffic is encrypted using HTTPS.
6. **Request Sanitization**: Sanitizing all request parameters to prevent injection attacks.
7. **API Keys**: For public APIs, implementing API keys with appropriate scopes and permissions.
8. **Audit Logging**: Comprehensive logging of API access and changes for security auditing.

## Explain how you would approach optimizing the performance of the API for handling large amounts of property data.

For optimizing the API to handle large amounts of property data, I would implement the following strategies:

1. **Database Indexing**: Create appropriate indexes on commonly queried fields such as province, price, and property_type.
2. **Pagination**: Ensure all endpoints that return lists implement proper pagination to limit the amount of data transferred.
3. **Caching**: Implement multi-level caching:
   - In-memory caching for frequently accessed data
   - Redis or Memcached for shared cache across instances
   - Browser caching for static resources
4. **Database Query Optimization**: Use query analysis tools to optimize database queries and use eager loading to prevent N+1 query problems.
5. **Database Sharding**: For very large datasets, consider horizontal sharding of the database by province or region.
6. **Materialized Views**: For complex aggregations or reports, use materialized views that are updated periodically.
7. **Content Delivery Network (CDN)**: Use a CDN for serving images and static assets.
8. **API Response Optimization**: Include only necessary fields in API responses and consider implementing sparse fieldsets.
9. **Asynchronous Processing**: Move time-consuming tasks to background jobs.
10. **Horizontal Scaling**: Design the application to allow horizontal scaling of API servers behind a load balancer.

## How would you track down a performance issue in production? Have you ever had to do this? If so, please describe the experience.

To track down a performance issue in production, I would follow these steps:

1. **Monitoring and Metrics Collection**: 
   - Use tools like New Relic, Datadog, or Prometheus to collect performance metrics
   - Set up proper logging with tools like ELK Stack (Elasticsearch, Logstash, Kibana)
   - Monitor application response times, error rates, and resource utilization

2. **Identify Bottlenecks**:
   - Check for slow database queries using query logs and explain plans
   - Look for memory leaks or high CPU usage
   - Monitor external API dependencies and their response times
   - Analyze network latency and throughput

3. **Reproduce and Isolate**:
   - Try to reproduce the issue in a test environment
   - Isolate the specific endpoint or functionality causing the problem
   - Use profiling tools to identify code-level issues

4. **Root Cause Analysis**:
   - Determine if the issue is related to code, infrastructure, or database
   - Check recent deployments or changes that might have introduced the problem
   - Analyze log patterns to identify recurring issues

5. **Implement and Verify Fix**:
   - Apply the fix in a test environment first
   - Monitor performance after the fix to ensure the issue is resolved
   - Document the issue and solution for future reference

**Personal Experience**:

I have tracked down performance issues in production environments several times. In one notable case, we had a real estate application similar to this one that was experiencing slow response times during peak hours.

Using New Relic monitoring, I identified that certain API endpoints were taking significantly longer to respond when filtering properties by multiple criteria. After analyzing the database queries, I discovered that we had missing composite indexes for the combination of fields frequently queried together.

I also found that we were making redundant database calls and not properly caching results. I implemented Redis caching for property listings with a TTL of 10 minutes, added the appropriate composite indexes, and optimized our ORM queries to use eager loading.

These changes reduced the average response time from over 3 seconds to under 300ms, significantly improving the user experience during high traffic periods. We also implemented a more robust monitoring system to alert us proactively about performance degradation in the future.

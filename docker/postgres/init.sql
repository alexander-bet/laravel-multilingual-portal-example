-- Create pgvector extension
CREATE EXTENSION IF NOT EXISTS vector;

-- Create utf8 encoding
ALTER DATABASE chinaglobalhub OWNER TO chinaglobalhub;

-- Grant privileges
GRANT ALL PRIVILEGES ON DATABASE chinaglobalhub TO chinaglobalhub;

\c chinaglobalhub

-- Create schema for vectors
CREATE SCHEMA IF NOT EXISTS vectors;
GRANT USAGE ON SCHEMA vectors TO chinaglobalhub;
GRANT CREATE ON SCHEMA vectors TO chinaglobalhub;
